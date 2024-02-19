

## Buat ENV
```env
SSO_USERNAME=
SSO_SECRET_KEY=
SSO_URL=
SSO_REDIRECT = '/dashboard'
```

## Konfigurasi manual providers app.php
Surya\Sso\Authenticated::class

## Buat Script di web.php
use Surya\Sso\Authenticated;

```php
Route::get('/login-sso', function () {
    $token = request('token') ?? null;
    $user =  Authenticated::authenticate($token);
    Auth::login($user);
    // Kondisi Jika Ada cth:  if role === admin redirect :
    return redirect('/dashboard');
});
```

