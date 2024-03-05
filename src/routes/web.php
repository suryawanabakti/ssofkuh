<?php

use Surya\Sso\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'web',
], function ($router) {
    require base_path('routes/web.php');

    $router->get("/active-user", function () {
        $user =  auth()->user();
        $token = $user->createToken('ssofkuh')->plainTextToken;
        $app_url = url('/');
        return redirect(env('SSO_URL') . "/trusted-host?token=$token&app_url=$app_url");
    })->middleware('auth');


    $router->get('/get-token', function (Request $request) {
        $token = PersonalAccessToken::findToken($request->token);
        if (empty($token)) {
            return "token tidak ditemukan";
        }
        return response()->json($token->tokenable()->first());
    });

    $router->get('/update-sso-token', function (Request $request) {

        $updated =  User::where('id', $request->user_id)->update([
            'sso_token' => $request->sso_token
        ]);

        if ($updated) {
            return response()->json([
                'message' => 'Berhasil terupdated',
                'update' => $updated,
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal update',
                'update' => $updated,
            ], 422);
        }
    });
});
