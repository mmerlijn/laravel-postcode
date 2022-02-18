<?php

use Illuminate\Support\Facades\Route;
use mmerlijn\laravelPostcode\Http\Controllers\PostcodeController;

Route::post('/', [PostcodeController::class, 'getAddress'])
    ->name('postcode.getAddress');
