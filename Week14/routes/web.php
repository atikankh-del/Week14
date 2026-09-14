<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BlogController;
//นักอ่าน
Route::get('/', [BlogController::class, 'index'])->name('welcome');
Route::get('/detail/{id}', [BlogController::class, 'detail'])->name('blogs.detail');
Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

//นักเขียน
Route::prefix('author')->group(function () {
    Route::get('/about', [AdminController::class, 'about'])->name('about');
    Route::get('/blog', [AdminController::class, 'blog'])->name('blog');
    Route::get('/create', [AdminController::class, 'form'])->name('form');
    Route::post('/insert', [AdminController::class, 'insert'])->name('insert');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('book.edit');
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('book.update');
    Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('book.delete');
    Route::delete('/chang/{id}', [AdminController::class, 'changestatus'])->name('book.chang');
});

Route::get('/books', [BookController::class, 'index'])->name('book');
Route::post('/books', [BookController::class, 'store'])->name('book.store');
Route::get('/test_db', function () {
    try {
        DB::connection('mysql')->getPdo();
        return 'เชื่อมต่อฐานข้อมูลสำเร็จ';
    } catch (\Throwable $th) {
        return 'Error: ' . $th->getMessage();
    }
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
