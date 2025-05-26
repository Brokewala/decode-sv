<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
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

// Pages publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', function() {
    return view('contact');
})->name('contact');

// Routes de langue
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/available', [LanguageController::class, 'getAvailableLocales'])->name('language.available');

// Routes Documents (attention à l'ordre des routes)
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

// Routes authentifiées
Route::middleware(['auth'])->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Gestion des documents
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/my-documents', [DocumentController::class, 'userDocuments'])->name('documents.my');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Téléchargement de documents
    Route::post('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Notation des documents
    Route::post('/documents/{document}/rate', [DocumentController::class, 'rate'])->name('documents.rate');
});

// La route show doit être placée après create pour éviter le conflit
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

// Authentification
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::post('/login', [HomeController::class, 'login'])->name('login.post');
Route::post('/register', [HomeController::class, 'register'])->name('register.post');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
