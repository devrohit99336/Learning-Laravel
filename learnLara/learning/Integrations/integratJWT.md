# Integrate JWT in laravel 

Refrence -> https://blog.pusher.com/laravel-jwt/

## Getting Started 

The first thing we are going to do is create a laravel application for testing JWT. If you have the Laravel installer, you can run the following command:

```
 $ laravel new laravel-jwt
```
using the command line.
```
$ composer create-project --prefer-dist laravel/laravel laravel-jwt
```
After creating laravel-jwt, navigate into the directory and install the third-party JWT package we will use. Due to an issue with the published version of tymon/jwt-auth, we are going to install the dev version of the package. Run the following command: 
```
$ composer require tymon/jwt-auth:dev-develop --prefer-source
```

Open **config/app.php** and add the following provider to the **providers** array:

```
Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
```

Add the following facades to the **aliases** array:

```
'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class, 
'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class,
```
You need to publish the config file for JWT using the following command:
```
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
When that is done, set the jwt-auth secret by running the following command:
```
$ php artisan jwt:secret
```
We need to make the User model implement JWT. Open app/User.php file and replace the content with this:

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     * @throws \Exception
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array<string, string>
     * @throws \Exception
     * @notice: This method is not used.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
```

We have defined the User model to implement JWTSubject. We also defined two methods to return the JWTIdentifier and JWTCustomClaims. Custom claims are used in generating the JWT token.

That concludes the installation of JWT. Let us proceed to set up the rest of our application.

## Setup the database

open the .env file and edit the database settings. Replace:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_password
```
Laravel comes with default migration for user’s table. We will not need any columns different from what it provides. Run the migrate command to create the table on the database:
```
$ php artisan migrate
```
Our database is ready now.

### Create the controllers
We are going to create two controllers for this guide: **UserController** and **DataController**.

The **UserController** will hold all our **authentication** logic, while the **DataController** will return sample data.
Create the controllers:

```
$ php artisan make:controller api/v1/UserController 
$ php artisan make:controller api/v1/DataController
```

Open the UserController file and edit as follows:

```
<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
```

The **authenticate** method attempts to log a user in and generates an authorization token if the user is found in the database. It throws an error if the user is not found or if an exception occurred while trying to find the user.

The **register** method validates a user input and creates a user if the user credentials are validated. The user is then passed on to **JWTAuth** to generate an access token for the created user. This way, the user would not need to log in to get it.

We have the **getAuthenticatedUser** method which returns the user object based on the authorization token that is passed.

Now, let us create sample data in the **DataController**:

```
<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function open()
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'), 200);
    }

    public function closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'), 200);
    }
}
```
Next thing is to make the API routes to test the JWT setup.

## Creating our routes

Before we define our API routes, we need to create a **JwtMiddleware** which will protect our routes. Run this command via your terminal.
```
$ php artisan make:middleware JwtMiddleware
```
This will create a new middleware file inside our Middleware directory. This file can be located here **app/Http/Middleware/JwtMiddleware**. Open up the file and replace the content with the following:

```
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware extends BaseMiddleware
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => 'Token is Invalid']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['status' => 'Token is Expired']);
                }else{
                    return response()->json(['status' => 'Authorization Token not found']);
                }
            }
            return $next($request);
        }
    }
```

This middleware extends **Tymon\JWTAuth\Http\Middleware\BaseMiddleware**, with this, we can catch token errors and return appropriate error codes to our users.

Next, we need to register our middleware. Open **app/http/Kernel.php** and add the following:

```
protected $routeMiddleware = [
    'jwt.verify' => \App\Http\Middleware\JwtMiddleware::class,
];
```
Next, Open routes/api.php and add the content with the following:

```
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\DataController;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'authenticate']);
    Route::get('/open', [DataController::class, 'open']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/user', [UserController::class, 'getAuthenticatedUser']);
        Route::get('/closed', [DataController::class, 'closed']);
    });
});
```
We defined all the routes we need to test out JWT. Every route we do not wish to secure is kept outside the JWT middleware.

Use this command to start your server through the terminal: **php artisan serve**

## Create a user account for testing

Endpoint : 127.0.0.1:8000/api/v1/register </br>
Method: POST</br>

name: Test Man</br>
email: test@email.com</br>
password: secret</br>
password_confirmation: secret</br>
