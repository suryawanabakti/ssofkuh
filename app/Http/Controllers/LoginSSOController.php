<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\NeedTrustedHost;
use App\Models\User;
use Illuminate\Http\Request;

class LoginSSOController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $user =  User::where('sso_token', request('sso_token') ?? null)->where('token', request('token') ?? null)->first();

        if (empty(request('sso_token'))) {
            return response()->json(["message" => "SSO Token Harus Ada"], 422);
        }

        if (empty($user)) {
            return response()->json([
                'message' => "Token tidak ditemukan / Tidak Sama ",
            ], 404);
        }

        $app  = App::where('name', request('app_name') ?? null)->first();

        if (!empty($app->need_trusted_host)) {
            $needTrustedHost = NeedTrustedHost::where('app_id', $app->id)->where('user_id', $user->id)->first();
            if (empty($needTrustedHost)) {
                return response()->json([
                    'message' => "Aplikasi ini Butuh trusted host",
                ], 404);
            }
        }

        return $user;
    }
}
