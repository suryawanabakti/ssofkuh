## Install Package
composer require suryawanabakti/sso

## Buat ENV
```env
SSO_USERNAME=
SSO_SECRET_KEY=
SSO_URL=
```

## Konfigurasi manual providers app.php (Optional)
```php
Surya\Sso\Authenticated::class
```

## Buat Script di web.php
```php
use Surya\Sso\Authenticated;

Route::get('/login-sso', function () {
    $token = request('token') ?? null;
    $user =  Authenticated::authenticate($token);
    Auth::login($user);
    // Kondisi Jika Ada cth:  if role === admin redirect :
    return redirect('/dashboard');
});
```

