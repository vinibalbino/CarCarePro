<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrandController;
use Illuminate\Foundation\Application;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/marcas', [BrandController::class, 'home'])->middleware(['auth', 'verified'])->name('marcas');
Route::get('/marcas/formulario', [BrandController::class, 'form'] )->middleware(['auth', 'verified'])->name('marcas.formulario');
Route::post('/marcas/adicionar', [BrandController::class, 'create'] )->middleware(['auth', 'verified'])->name('marcas.adicionar');
Route::put('/marcas/editar/${id}', [BrandController::class, 'editar'] )->middleware(['auth', 'verified'])->name('marcas.editar');
Route::delete('/marcas/delete', [BrandController::class, 'destroy'] )->middleware(['auth', 'verified'])->name('marcas.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
