<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Enums;

enum PasswordHashType: string
{
    case BCRYPT = 'bcrypt';

    case FIREBASE = 'firebase-scrypt';

    case SSHA = 'ssha';
}
