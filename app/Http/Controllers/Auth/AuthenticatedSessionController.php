<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\App;
use App\Models\NeedTrustedHost;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();
        $request->session()->regenerate();
        if ($request->token) {
            $app = App::where('url', $request->app_url)->first();

            if (empty($app)) {
                return response()->json([
                    'message' =>  "URL TIDAK ADA DI DATABASE SSO",
                ], 422);
            }

            $dataTrusted = NeedTrustedHost::where('user_id', auth()->id())->where('app_id', $app->id)->count();
            if ($dataTrusted === 0) {

                $user =  Http::get($request->app_url . '/get-token', [
                    "token" => $request->token
                ]);

                $user = json_decode($user);

                Http::get($request->app_url . '/update-sso-token', [
                    "user_id" => $user->id,
                    "sso_token" => auth()->user()->sso_token
                ]);

                NeedTrustedHost::create([
                    'user_id' => auth()->id(),
                    'app_id' => $app->id
                ]);

                return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Berhasil mengaktifkan akun sso');
            } else {
                $message = "Akun ini sudah terhubung";
                return redirect('/errors?message=' . $message . "&callBackUrl={$app->url}");
            }
        }

        User::find(auth()->id())->update([
            'token' => (string)str()->uuid()
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
