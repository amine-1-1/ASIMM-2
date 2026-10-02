<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route:: get('/', [HomeController::class, 'index'])->name('hame');


