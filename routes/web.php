<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])
    ->name('tasks.')
    ->prefix('tasks')
    ->controller(TaskController::class)
    ->group(function () {
        // index / create / store
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        // show / edit
        Route::get('/{task}', 'show')->name('show');
        Route::get('/{task}/edit', 'edit')->name('edit');

        // update (PUT/PATCH) e destroy
        Route::put('/{task}', 'update')->name('update');
        Route::patch('/{task}', 'update');
        Route::delete('/{task}', 'destroy')->name('destroy');

        Route::patch('/{task}/move', 'move')->name('move');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';



