<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    // User::first()->delete(); // Delete first data in users table from database
    $user = User::get();// Get all users table from database
    //$user2 = User::withTrashed()->get();// Get all users (with delated data) table from database
    //User::onlyTrashed()->whereId(3)->restore();// Restore deleted(trashded) users data
    //User::withTrashed()->restore();// Restore all deleted(trashded) users data
    //$user3 = User::onlyTrashed()->get();     // Get only deleted(trashded) users table from database
    dd($user->toArray());    // Display users in home page array format
    return view('welcome');
});
