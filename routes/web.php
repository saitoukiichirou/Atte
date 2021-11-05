<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::post('/punchin', [AtteController::class, 'punchIn']);
Route::post('/punchout', [AtteController::class, 'punchOut']);

Route::post('/restin', [AtteController::class, 'restIn']);
Route::post('/restout', [AtteController::class, 'restOut']);

