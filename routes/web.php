<?php

use App\Http\Controllers\AtteController;
use App\Http\Controllers\DateController;
use Illuminate\Support\Facades\Route;

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

//ログインが必要なページ, verify後にアクセス可能
Route::middleware(['verified'])->group(function (){
    Route::get('/dashboard', [AtteController::class, 'index']);
    Route::get('/', [AtteController::class, 'index'])->name('dashboard');

    Route::post('/punchin', [AtteController::class, 'punchIn']);
    Route::post('/punchout', [AtteController::class, 'punchOut']);

    Route::post('/restin', [AtteController::class, 'restIn']);
    Route::post('/restout', [AtteController::class, 'restOut']);

    Route::get('/attendance/{date?}', [DateController::class, 'index']);
    Route::get('/users', [DateController::class, 'usersList']);
    Route::get('/users/{id?}/{month?}', [DateController::class, 'userMonthAtte']);
});

//ログインが不要なページ
Route::get('/login', function () {
    return view('dashboard');
});
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['verified']);

require __DIR__.'/auth.php';
