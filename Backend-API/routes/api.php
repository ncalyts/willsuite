<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Grouped routes for accessing the notes controller methods
Route::prefix('notes')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('index');
        Route::get('/{id}', [NoteController::class, 'show']);
        Route::post('/', [NoteController::class, 'store']);
        Route::put('/{id}', [NoteController::class, 'update']);
        Route::delete('/{id}', [NoteController::class, 'delete']);
});
