<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/todos', 'pages.todos.index')
    ->name('todos.index');