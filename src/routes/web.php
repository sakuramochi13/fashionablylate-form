<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;

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

Route::get('/', [ContactController::class, 'create']);
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
Route::get('/confirm',  [ContactController::class, 'showConfirm'])->name('contacts.confirm.show');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::view('/thanks', 'thanks')->name('thanks');
Route::view('/admin', 'auth.admin')
    ->middleware(['auth'])
    ->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::delete('/admin/contacts/{contact}', [AdminController::class, 'destroy'])
    ->name('contacts.destroy');

Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');

Route::post('/confirm/back', [SessionController::class, 'backToEdit'])->name('contacts.back');