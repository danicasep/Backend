<?php

use App\Http\Middleware\PublicMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
  Route::middleware([PublicMiddleware::class])->group(function () {

    Route::post("/login", [\App\Http\Controllers\AuthController::class, 'login']);

    Route::prefix("cctv")->group(function () {
      Route::get('/paginate/{id}',            [\App\Http\Controllers\CctvController::class, 'detailPagination']);
      Route::get('/categories/{unitId}',      [\App\Http\Controllers\CctvController::class, 'category']);
      Route::get('/list/{categoryId}',        [\App\Http\Controllers\CctvController::class, 'index']);
      Route::get('/{id}',                     [\App\Http\Controllers\CctvController::class, 'show']);
    });

    Route::middleware([UserMiddleware::class])->group(function () {
      Route::prefix("user")->group(function () {
        Route::prefix("cctv")->group(function () {

          Route::get('/units',           [\App\Http\Controllers\Admin\CctvCategoryController::class, 'unit']);

          Route::prefix("categories")->group(function () {
            Route::get('/',             [\App\Http\Controllers\Admin\CctvCategoryController::class, 'index']);
            Route::get('/{id}',         [\App\Http\Controllers\Admin\CctvCategoryController::class, 'show']);
            Route::post('/form/{id?}',  [\App\Http\Controllers\Admin\CctvCategoryController::class, 'form']);
            Route::delete('/{id}',      [\App\Http\Controllers\Admin\CctvCategoryController::class, 'delete']);
          });

          Route::prefix("camera")->group(function () {
            Route::get('/restart-all',  [\App\Http\Controllers\Admin\CctvController::class, 'restartAllCctvs']);
          });

          Route::prefix("/")->group(function () {
            Route::get('/',             [\App\Http\Controllers\Admin\CctvController::class, 'index']);
            Route::get('/{id}',         [\App\Http\Controllers\Admin\CctvController::class, 'show']);
            Route::put('/{id}',         [\App\Http\Controllers\Admin\CctvController::class, 'updateStatus']);
            Route::post('/form/{id?}',  [\App\Http\Controllers\Admin\CctvController::class, 'form']);
            Route::delete('/{id}',      [\App\Http\Controllers\Admin\CctvController::class, 'delete']);
          });
        });
      });
    });
  });
});
