<?php

use App\Http\Controllers\AdminSSO\UsersController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\ProfileController;
use App\Models\App;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $token = (string) str()->uuid();
    $apps = App::orderBy('created_at', 'desc')->get();
    User::find(auth()->id())->update([
        'token' => $token
    ]);
    return view('dashboard', compact('token', 'apps'));
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/login-sso', function () {
    $user =  User::where('token', request('token') ?? null)->first();

    if (empty($user)) {
        return response()->json([
            'message' => "Token tidak ditemukan"
        ], 404);
    }

    return $user;
})->middleware('ssoauth');

Route::middleware('auth')->group(function () {
    Route::middleware('role:adminsso')->group(function () {
        Route::get('/apps',  [AppsController::class, 'index']);
        Route::get('/apps/create',  [AppsController::class, 'create']);
        Route::post('/apps',  [AppsController::class, 'store']);
        Route::delete('/apps/{app}',  [AppsController::class, 'destroy']);

        Route::get('/users', [UsersController::class, 'index']);
        Route::get('/users/create', [UsersController::class, 'create']);
        Route::post('/users', [UsersController::class, 'store']);
        Route::delete('/users/{user}', [UsersController::class, 'destroy']);
        Route::post('/users/import', [UsersController::class, 'import']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
