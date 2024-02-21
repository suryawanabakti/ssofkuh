<?php

namespace Surya\Sso;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Surya\Sso\Exceptions\SSOFkUhExcetion;

class Authenticated extends ServiceProvider
{
    private $url;
    private $http;
    public $response;



    public function __construct()
    {
        $this->url = env("SSO_URL");

        $this->http = Http::withHeaders(
            [
                'username' => env('SSO_USERNAME'),
                'password' => env('SSO_SECRET_KEY')
            ]
        );
    }

    public static function authenticate($token, $sso_token, $appname)
    {
        $self = new static;
        $response = $self->http
            ->get("{$self->url}/login-sso", [
                "token" => $token,
                "sso_token" => $sso_token,
            ]);

        throw_if($response->failed(), SSOFkUhExcetion::withResponse($response));

        $user = User::where('sso_token', $response['sso_token'])->first();

        if (!empty($user)) {
            if (auth()->user()) {
                Auth::guard('web')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }
            return $user;
        }

        throw_if(empty($user), SSOFkUhExcetion::withResponse(response()->json([
            'message' => "SSO Token tidak di temukan di " . $appname,
        ], 404)));

        $self->response = $user;

        return $self;
    }
}
