<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>


<div class="p-6">
    <h1>Todos Page</h1>
    <p>Livewire v4 is working.</p>

    <div class="mt-4">
        <a href="{{ route('todos.create') }}" wire:navigate>Create Todo</a>
        <br>
        <a href="{{ route('todos.view', ['todo' => 1]) }}" wire:navigate>View Todo</a>
        <br>
        <a href="{{ route('todos.edit', ['todo' => 1]) }}" wire:navigate>Edit Todo</a>
        <br>
        <a href="{{ route('todos.delete', ['todo' => 1]) }}" wire:navigate>Delete Todo</a>
    </div>
</div>