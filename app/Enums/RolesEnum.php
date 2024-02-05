<?php

namespace App\Enums;

enum RolesEnum: string
{
    case root = 'root';
    case admin_system = 'admin_system';
    case admin_school = 'admin_school';
    case accountant  = 'accountant';
    case teacher = 'teacher';
    case student = 'student';
    case parent = 'parent';

    public function label(): string
    {
        return match ($this) {
            self::root => 'root',
            self::admin_system => 'admin_system',
            self::admin_school => 'admin_school',
            self::accountant => 'accountant',
            self::teacher => 'teacher',
            self::student => 'student',
            self::parent => 'parent',
        };
    }

    public function has($student) : bool
    {
        return $this->value === $student;
    }
}
