## Install Package
composer require suryawanabakti/sso

## Add Sso token 
php artisan migrate

## Buat ENV
```env
SSO_USERNAME=
SSO_SECRET_KEY=
SSO_URL=
```

## Buat Script di web.php
```php
use Surya\Sso\Authenticated;

Route::get('/login-sso', function () {
    $user =  Authenticated::authenticate(request('token'), request('sso_token'), request('app_url'));
    Auth::login($user);
    // Kondisi Jika Ada cth:  if role === admin redirect :
    return redirect('/dashboard');
});
```

## Aplikasi yang butuh trusted host
```php
GET /active-user
```






