<?php

use App\Http\Controllers\FormAnswerController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('forms', FormController::class);
    Route::get('forms/preview/{form}', [FormController::class, 'preview'])->name('forms.preview');
     

    Route::post('forms/{form}/answers', [FormAnswerController::class, 'store'])->name('forms.answers.store');
    Route::get('forms/{form}/answers', [FormAnswerController::class, 'show'])->name('forms.answers.show');
});

Route::get('thank-you', function () {
    return view('forms.thankyou');
})->name('forms.thankyou');

require __DIR__ . '/auth.php';
