<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route ouverte à tous
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profiles', [ProfileController::class, 'indexPublic']);

//Routes protégée, authentification necessaire
Route::middleware('auth:sanctum')->post('/profiles', [ProfileController::class, 'store']);
