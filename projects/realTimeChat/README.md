# Realtime Chat

This is a realtime chat system that runs in Laravel with the help of real time components. For which [Laravel](https://laravel.com/docs/9.x), [Pusher](https://beyondco.de/docs/laravel-websockets/basic-usage/pusher) and [Laravel Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction) have been used.

## Creation -

### Step 1 - Create laravel project -
**Using composer -**

Syntax -

    composer create-project --prefer-dist laravel/laravel Project_name version

Example -

    composer create-project --prefer-dist laravel/laravel blog 7.x

**Using laravel installer -**

Syntax -

    laravel new project_name

Example -

    laravel new blog

<br>

### Step 2 - [install UI and vue with auth](https://laravel.com/docs/7.x/frontend) -

install laravel/ui Composer package -

    composer require laravel/ui

Generate basic scaffolding -

    php artisan ui vue

Generate login / registration scaffolding -    

    php artisan ui vue --auth

Generate all UI pakadge components -

    npm install

create, compile and mix UI -

    npm run dev

### Step 3 - Update Vuejs Version 

लारवेल By default vue js का 2nd version प्रदान करता है  जो की पुराना version है अतः हम उसका वर्शन update करने के लिए package.json फाइल के devDependencies सेक्शन में vuejs के तीसरे version को जोड़ देते है -

```diff

"devDependencies": {
        "@popperjs/core": "^2.10.2",
        "axios": "^0.25",
        "bootstrap": "^5.1.3",
        "laravel-mix": "^6.0.6",
        "lodash": "^4.17.19",
        "postcss": "^8.1.14",
        "resolve-url-loader": "^3.1.2",
        "sass": "^1.32.11",
        "sass-loader": "^11.0.1",
+        "vue": "^3.2.31",
        "vue-template-compiler": "^2.6.12"
    },

```

pakadge.json के बदलावों को इनस्टॉल करनॆ कॆ लियॆ हमॆ फिर से एक बार npm install command चलाना हॊगा -

install add new pakadge components -

    npm install

### Step 4 - Add websockets and pusher php packadges in composer.json file-

```diff
"require": {
        "php": "^8.0.2",
        "guzzlehttp/guzzle": "^7.2",
        "laravel/framework": "^9.2",
        "laravel/sanctum": "^2.14.1",
        "laravel/tinker": "^2.7",
        "laravel/ui": "^3.4",

+        "beyondcode/laravel-websockets":"^1.12",
+        "pusher/pusher-php-server":"^5.0"
    },
```

install add and changes pakadges in composer.json file -

    composer update
    
## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/migrations)
 

Clone the repository

    git clone https://github.com/rohit99336/Cupidknot2.0

Switch to the repo folder

    cd project folder

Install all the dependencies using composer

    composer install

Install all the node dependencies using npm

    npm install

mix all the node dependencies using npm

    npm run dev

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**command list**

    git clone https://github.com/rohit99336/Cupidknot2.0
    npm install
    composer install
    npm run dev
    php artisan key:generate
    php artisan migrate
    php artisan serve
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve



