<?php

namespace App\Constants;

class RoleConstants
{
    public const ROOT = 'root';
    public const ADMIN = 'admin';

    public const ALL = [
        self::ROOT,
        self::ADMIN,
    ];
}
