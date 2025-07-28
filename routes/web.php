<?php

use Illuminate\Support\Facades\Route;

// temporary routes
Route::get('/admin/login', function () {
    return view('admin.admin_login');
});
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
Route::get('/admin/transactions', function () {
    return view('admin.transactions.index');
});
Route::get('/admin/users', function () {
    return view('admin.users.index');
});
Route::get('/admin/items', function () {
    return view('admin.items.index');
});
Route::get('/about', function () {
    return view('about');
});

Route::get('/transaction', function () {
    return view('transaction');
});

Route::get('/booking', function () {
    return view('booking');
});

Route::get('/account', function () {
    return view('account.index');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
