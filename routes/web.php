<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/todos', 'pages.todos.⚡index')
    ->name('todos.index');

Route::livewire('/todos/create', 'pages.todos.⚡create')
    ->name('todos.create');

Route::livewire('/todos/{todo}/edit', 'pages.todos.⚡edit')
    ->name('todos.edit');

Route::livewire('/todos/{todo}/delete', 'pages.todos.⚡delete')
    ->name('todos.delete');

Route::livewire('/todos/{todo}', 'pages.todos.⚡view')
    ->name('todos.view');