<?php

use App\Http\Controllers\AdminSSO\UsersController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConnectedController;
use App\Http\Controllers\LoginSSOController;
use App\Http\Controllers\NeedTrustedHostController;
use App\Http\Controllers\ProfileController;
use App\Models\App;
use App\Models\Category;
use App\Models\NeedTrustedHost;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/dashboard', function () {
    $token = (string) str()->uuid();
    $categories = Category::with('apps')->orderBy('created_at', 'desc')->get();
    User::find(auth()->id())->update([
        'token' => $token,
    ]);
    return view('dashboard', compact('token', 'categories'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/trusted-host', function (Request $request) {

    $app = App::where('url', $request->app_url)->first();
    if (empty($app)) {
        $message = "URL Web Tidak ada di database SSO";
        return redirect('/errors?message=' . $message . "&callBackUrl={$request->url}");
    }

    if (auth()->user()) {
        $dataTrusted = NeedTrustedHost::where('user_id', auth()->id())->where('app_id', $app->id)->count();
        if ($dataTrusted === 0) {
            $user =  Http::get($request->app_url . '/get-token', [
                "token" => $request->token
            ]);

            $user = json_decode($user);

            $updated = Http::get($request->app_url . '/update-sso-token', [
                "user_id" => $user->id,
                "sso_token" => auth()->user()->sso_token
            ]);

            if ($updated["update"] === 1) {
                NeedTrustedHost::create([
                    'user_id' => auth()->id(),
                    'app_id' => $app->id
                ]);
                return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Berhasil mengaktifkan akun sso');
            }

            return "Gagal Update AKUN SSO";
        } else {
            $message = "Akun ini sudah memiliki token  :" . auth()->user()->token;
            return redirect('/errors?message=' . $message . "&callBackUrl={$app->url}");
        }
    } else {
        return redirect('/get-token-sso' . "?token={$request->token}&app_url={$request->app_url}");
    }
});

Route::get('get-token-sso', function (Request $request) {
    $token = $request->token;
    $app_url = $request->app_url;

    return view('auth.get-token-sso', compact('token', 'app_url'));
})->middleware(['guest']);

Route::get('/delete-all-connecting', function () {
    NeedTrustedHost::where('user_id', auth()->id())->delete();
})->middleware(['auth']);

Route::get('/login-sso', LoginSSOController::class)->middleware('ssoauth');

Route::get('/errors', function () {
    return view('errors.index');
});

Route::get('/get-sso-token', function () {
    echo Cookie::get("sso_token");
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:adminsso')->group(function () {
        Route::get('/categories',  [CategoryController::class, 'index']);
        Route::get('/categories/create',  [CategoryController::class, 'create']);
        Route::post('/categories',  [CategoryController::class, 'store']);
        Route::get('/categories/{category}/edit',  [CategoryController::class, 'edit']);
        Route::patch('/categories/{category}',  [CategoryController::class, 'update']);
        Route::delete('/categories/{category}',  [CategoryController::class, 'destroy']);

        Route::get('/apps',  [AppsController::class, 'index']);
        Route::get('/apps/create',  [AppsController::class, 'create']);
        Route::post('/apps',  [AppsController::class, 'store']);
        Route::get('/apps/{app}/edit',  [AppsController::class, 'edit']);
        Route::put('/apps/{app}',  [AppsController::class, 'update']);
        Route::delete('/apps/{app}',  [AppsController::class, 'destroy']);

        Route::get('/apps/{app}/need-trusted-host',  [NeedTrustedHostController::class, 'index']);
        Route::delete('/apps/{needTrustedHost}/need-trusted-host',  [NeedTrustedHostController::class, 'destroy']);

        Route::get('/users', [UsersController::class, 'index']);
        Route::get('/users/create', [UsersController::class, 'create']);
        Route::post('/users', [UsersController::class, 'store']);
        Route::get('/users/{user}/edit', [UsersController::class, 'edit']);
        Route::patch('/users/{user}', [UsersController::class, 'update']);
        Route::delete('/users/{user}', [UsersController::class, 'destroy']);
        Route::post('/users/import', [UsersController::class, 'import']);
        Route::get('/users/export', [UsersController::class, 'export']);
    });

    Route::get('/connected', [ConnectedController::class, 'index']);
    Route::get('/connected/{id}/delete', [ConnectedController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
