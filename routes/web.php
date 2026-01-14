<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductsList;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view/products', ProductsList::class);