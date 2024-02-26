<?php

use Surya\Sso\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;

Route::get("/active-user/{user_id}", function ($user_id) {
    $user = User::find($user_id);
    $token = $user->createToken('ssofkuh')->plainTextToken;
    $app_url = url('/');
    return redirect(env('SSO_URL') . "/trusted-host?token=$token&app_url=$app_url");
});

Route::get('/get-token', function (Request $request) {
    $token = PersonalAccessToken::findToken($request->token);
    if (empty($token)) {
        return "token tidak ditemukan";
    }
    return response()->json($token->tokenable()->first());
});

Route::get('/update-sso-token', function (Request $request) {

    $updated =  User::where('id', $request->user_id)->update([
        'sso_token' => $request->sso_token
    ]);

    return response()->json([
        'message' => 'Berhasil terupdated',
        'update' => $updated,
    ]);
});
