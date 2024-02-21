<?php

use Illuminate\Support\Facades\Http;

Route::get("/active-user", function () {
    return Http::withHeaders([
        'username' => env('SSO_USERNAME'),
        'password' => env('SSO_SECRET_KEY')
    ])->get(env("SSO_URL" . "/get-sso-token"));
});
