<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route:: get('/', [HomeController::class, 'index'])->name('hame');


