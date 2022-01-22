<?php

use App\Models\Import\Sources\FilesystemProvider;
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

Route::get('/history', function () {
    return Inertia::render('Main/History');
})->middleware(['auth', 'verified'])->name('history');


Route::get('/test', function (\App\Import\ImportSourceInterface $sourceLocator) {
    foreach ($sourceLocator->getItems() as $item) {
        $d = 5;
    }
})->name('history');

require __DIR__.'/auth.php';
