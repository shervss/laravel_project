<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_TODOS = 'view todos';
    case CREATE_TODOS = 'create todos';
    case UPDATE_TODOS = 'update todos';
    case DELETE_TODOS = 'delete todos';
    case VIEW_ACTIVITY_LOGS = 'view activity logs';

    public function label(): string
    {
        return match ($this) {
            self::VIEW_TODOS => 'View Todos',
            self::CREATE_TODOS => 'Create Todos',
            self::UPDATE_TODOS => 'Update Todos',
            self::DELETE_TODOS => 'Delete Todos',
            self::VIEW_ACTIVITY_LOGS => 'View Activity Logs',
        };
    }
}
