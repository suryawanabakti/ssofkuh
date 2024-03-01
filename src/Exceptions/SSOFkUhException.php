<?php

namespace Surya\Sso\Exceptions;

use Illuminate\Http\Request;
use Exception;

class SSOFkUhException extends Exception
{
    public $response;

    public static function withResponse($response)
    {
        $self = new static;
        $self->response = $response;

        return $self;
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
        $response = $this->response;

        if (is_object($response)) {
            $message = $response->original["message"] ?? $response["message"];
        } else {
            $message = $response["message"] ?? $response->original["message"];
        }

        $message .= " " . env("APP_NAME");
        return redirect(env('SSO_URL') . "/errors?message=$message");
    }
}
