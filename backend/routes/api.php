<?php

use App\Http\Middleware\PublicMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
  Route::middleware([PublicMiddleware::class])->group(function () {

    Route::prefix("cctv")->group(function () {
      Route::get('/categories',       [\App\Http\Controllers\CctvController::class, 'category']);
      Route::get('/list/{categoryId}',[\App\Http\Controllers\CctvController::class, 'index']);
      Route::get('/detail/{id}',      [\App\Http\Controllers\CctvController::class, 'show']);
    });
  });
});
