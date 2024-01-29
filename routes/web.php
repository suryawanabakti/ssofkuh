<?php

use App\Http\Controllers\AdminSSO\UsersController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $token = (string) str()->uuid();
    $categories = Category::with('apps')->orderBy('created_at', 'desc')->get();
    User::find(auth()->id())->update([
        'token' => $token
    ]);
    return view('dashboard', compact('token', 'categories'));
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

        Route::get('/users', [UsersController::class, 'index']);
        Route::get('/users/create', [UsersController::class, 'create']);
        Route::post('/users', [UsersController::class, 'store']);
        Route::get('/users/{user}/edit', [UsersController::class, 'edit']);
        Route::patch('/users/{user}', [UsersController::class, 'update']);
        Route::delete('/users/{user}', [UsersController::class, 'destroy']);
        Route::post('/users/import', [UsersController::class, 'import']);
        Route::get('/users/export', [UsersController::class, 'export']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
