<?php

namespace Surya\Sso\Exceptions;

use Illuminate\Http\Request;
use Exception;

class SSOFkUhExcetion extends Exception
{
    public $response;

    public static function withResponse($response)
    {
    }

    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request)
    {
        return  redirect('/')->withErrors(['message' => "Token tidak sama / tidak ditemukan di aplikasi ini"]);
    }
}
