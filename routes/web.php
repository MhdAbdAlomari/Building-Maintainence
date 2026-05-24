<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create-admin', function () {
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@shamfix.com',
        'password' => bcrypt('password'),
        'phone' => '0000000000',
        'role' => 'admin',
    ]);
    return 'Admin created!';
});