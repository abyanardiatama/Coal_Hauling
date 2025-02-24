<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//redirect / to /admin
Route::redirect('/','/admin');
