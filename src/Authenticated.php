<?php

namespace Surya\Sso;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    public static function authenticate($token)
    {
        $self = new static;
        $response = $self->http
            ->get("{$self->url}/login-sso", [
                "token" => $token
            ]);

        $user = User::where('username', $response['username'])->first();

        if (!empty($user)) {
            if (auth()->user()) {
                Auth::guard('web')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }
            return $user;
        } else {
            return abort(404);
        }
    }
}
