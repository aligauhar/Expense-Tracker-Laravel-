<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index2']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/add', [HomeController::class, 'add']);
Route::get('/dashboard', [HomeController::class, 'dashboard']);

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login2', [HomeController::class, 'login2']);

Route::get('/register', [HomeController::class, 'register']);
Route::post('/register2', [HomeController::class, 'register2']);
Route::get('/setting', [HomeController::class, 'setting']);

Route::post('/productadd', [HomeController::class, 'productadd'])->name('productadd');

Route::post('/setExpenseLimit', [HomeController::class, 'setExpenseLimit'])->name('setExpenseLimit');

Route::get('/generate-report', [HomeController::class, 'generateReport']);
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
