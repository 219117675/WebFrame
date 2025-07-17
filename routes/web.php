<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('/about', function () {
    return view('about');
});

//Route::get('/index', function () {
  //  return view('index');
//});

Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/event', function () {
    return view('event');
});

Route::get('/confirmation', function () {
    return view('confirmation');
});

Route::get('/login', function () {
    return view('login');
});

