# Laravel Socialite Login with Google Gmail Account

Refrence -> https://www.itsolutionstuff.com/post/laravel-8-socialite-login-with-google-account-exampleexample.html

## Create Project - 
In this step, if you haven't laravel application setup then we have to get fresh laravel 8 application. So run bellow command and get clean fresh laravel application.

```
composer create-project --prefer-dist laravel/laravel projectName
```

## Create Auth system - 

First create laravel authentication for restration and login functionality. sothat you are use Install JetStream and create new authentication system or use native laravel authentication.

### Using JetStream -

<u>Install JetStream</u> - Now, in this step, we need to use composer command to install jetstream, so let's run bellow command and install bellow library.

```
composer require laravel/jetstream
```
now, we need to create authentication using bellow command. you can create basic login, register and email verification. if you want to create team management then you have to pass addition parameter. you can see bellow commands:
```
php artisan jetstream:install livewire
```
Now, let's node js package:
```
npm install
```
let's run package:
```
npm run dev
````
now, we need to run migration command to create database table:
```
php artisan migrate
```
//==========================================   //  =================================================//
### Using Native Laravel Authentication -

The Bootstrap and Vue scaffolding provided by Laravel is located in the laravel/ui Composer package, which may be installed using Composer:
```
composer require laravel/ui
```
Once the laravel/ui package has been installed, you may install the frontend scaffolding using the ui Artisan command:

```
// Generate basic scaffolding (choose anyone of the following)
php artisan ui bootstrap
php artisan ui vue
php artisan ui react
 
// Generate login / registration scaffolding (choose anyone of the following)
php artisan ui bootstrap --auth
php artisan ui vue --auth
php artisan ui react --auth
```
Before compiling your CSS, install your project's frontend dependencies using the Node package manager (NPM):
```
npm install
```
Once the dependencies have been installed using npm install, you can compile your SASS files to plain CSS using Laravel Mix. The npm run dev command will process the instructions in your webpack.mix.js file. Typically, your compiled CSS will be placed in the public/css directory:

```
npm run dev
```
configure your database connection in your .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_user
DB_PASSWORD=database_password
```
now, we need to run migration command to create database table:
```
php artisan migrate
```

## Install Socialite
In first step we will install Socialite Package that provide api to connect with google account. So, first open your terminal and run bellow command:
```
composer require laravel/socialite
```

## Create Google App

In this step we need google client id and secret that way we can get information of other user. so if you don't have google app account then you can create from here : Google Developers Console.<br>
    1. create new project <br>
    2. create new ceadential using google api - Now you have to click on Credentials and choose first option oAuth and click Create new Client ID button<br>
    3. Now you have to set callback url in google api.<br>
    4. Now you have to set web application type in google api.<br>
    5. Now you have to set authorization scopes in google api.<br>


Now you have to set app id, secret and call back url in config file so open config/services.php and set id and secret this way:

**config/services.php**
```
'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],
```
after add this configuration file, you add this line in .env file:

```
GOOGLE_CLIENT_ID = your google client id
GOOGLE_CLIENT_SECRET = your google client secret
GOOGLE_REDIRECT = your google redirect url
```

## Add Database Column -
In this step first we have to create migration for add google_id in your user table. So let's run bellow command:
```
php artisan make:migration add_google_id_column --table=users
```
after create migration file then add column in migration file:

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
        });
    }
};
```
## add google_id in User model -

```
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

## Create Routes
```
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\auth\GoogleController;

Route::group(['prefix' => 'v1'], function () {

    // login with google
    Route::group(['middleware' => ['web']], function () {
        Route::get('/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
    });
});
```
## Create Controller

After add route, we need to add method of google auth that method will handle google callback url and etc, first put bellow code on your GoogleController.php file.

```
php artisan make:controller api/v1/GoogleController
```

after create controller file then add bellow code in controller file:

```
<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->user();
       
            $finduser = User::where('google_id', $user->id)->first();
       
            if($finduser){
       
                Auth::login($finduser);
      
                return redirect()->intended('dashboard');
       
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
      
                Auth::login($newUser);
      
                return redirect()->intended('dashboard');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
```

## Update Blade File

Ok, now at last we need to add blade view so first create new file login.blade.php file and put bellow code:
```
<div class="flex items-center justify-end mt-4">
    <a href="{{ route('google.redirect') }}">
        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em;">
    </a>
</div>
````
