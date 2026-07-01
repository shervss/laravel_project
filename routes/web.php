<?php

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dev-login', function (Request $request) {
    abort_unless(
        app()->isLocal() || in_array($request->getHost(), ['127.0.0.1', 'localhost'], true),
        404
    );

    $user = User::where('email', 'test@example.com')->firstOrFail();

    setPermissionsTeamId(1);
    $request->session()->put('permissions_team_id', 1);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('activity-logs.index');
})->name('dev-login');

Route::livewire('/todos', 'pages.todos.⚡index')
    ->middleware('permission:'.PermissionEnum::VIEW_TODOS->value)
    ->name('todos.index');

Route::livewire('/todos/create', 'pages.todos.⚡create')
    ->middleware('permission:'.PermissionEnum::CREATE_TODOS->value)
    ->name('todos.create');

Route::livewire('/todos/{todo}/edit', 'pages.todos.⚡edit')
    ->middleware('permission:'.PermissionEnum::UPDATE_TODOS->value)
    ->name('todos.edit');

Route::livewire('/todos/{todo}/delete', 'pages.todos.⚡delete')
    ->middleware('permission:'.PermissionEnum::DELETE_TODOS->value)
    ->name('todos.delete');

Route::livewire('/todos/{todo}', 'pages.todos.⚡view')
    ->middleware('permission:'.PermissionEnum::VIEW_TODOS->value)
    ->name('todos.view');

Route::livewire('/activity-logs', 'pages.activity-logs.index')
    ->middleware('permission:'.PermissionEnum::VIEW_ACTIVITY_LOGS->value)
    ->name('activity-logs.index');
