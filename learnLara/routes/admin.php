<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('admin');
})->name('home');

// Route::get('/blog', function () {
//     return view('blog');
// })->name('blog')->middleware('undeconstruction');

// Route::get('/about', function () {
//     return view('about');
// })->name('about');

Route::middleware(['construction'])->group(function(){

    Route::get('/blog', function () {
        return view('blog');
    })->name('blog')->middleware('undeconstruction');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

});
