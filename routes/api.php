<?php

use App\Http\Controllers\Api\NewsControllerApi;
use Illuminate\Support\Facades\Route;

Route::get('/news', [NewsControllerApi::class, 'index']);
Route::get('/news/slug/{slug}', [NewsControllerApi::class, 'showBySlug']);
Route::get('/news/{news}', [NewsControllerApi::class, 'show']);
Route::post('/news', [NewsControllerApi::class, 'store']);
Route::patch('/news/{news}', [NewsControllerApi::class, 'update']);
Route::delete('/news/{news}', [NewsControllerApi::class, 'destroy']);
