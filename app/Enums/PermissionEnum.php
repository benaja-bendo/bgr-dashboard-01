<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case create = 'create';
    case read = 'read';
    case update = 'update';
    case delete = 'delete';

    public function label(): string
    {
        return match ($this) {
            self::create => 'create',
            self::read => 'read',
            self::update => 'update',
            self::delete => 'delete',
        };
    }

    public function has($permission) : bool
    {
        return $this->value === $permission;
    }
}
