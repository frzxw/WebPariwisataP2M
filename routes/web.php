<?php

use Illuminate\Support\Facades\Route;

// temporary routes
Route::get('/admin/login', function () {
    return view('admin.login');
});
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
Route::get('/admin/transaction', function () {
    return view('admin.transaction.index');
});

Route::get('/transaction', function () {
    return view('transaction');
});

Route::get('/booking', function () {
    return view('booking');
});
