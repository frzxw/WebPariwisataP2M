<?php

use Illuminate\Support\Facades\Route;

// temporary routes
Route::get('/admin/login', function () {
    return view('admin.login');
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
// temporary routes
