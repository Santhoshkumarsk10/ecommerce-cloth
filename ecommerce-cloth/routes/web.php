<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    // dd('jb');
    return view('app');
})->where('any', '.*');
