<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Enums;

enum GrantType: string
{
    case CODE = 'authorization_code';

    case PASSWORD = 'password';

    case MAGICAUTH = 'urn:workos:oauth:grant-type:magic-auth:code';

    case REFRESHTOKEN = 'refresh_token';

    case EMAILCODE = 'urn:workos:oauth:grant-type:email-verification:code';

    case OTP = 'urn:workos:oauth:grant-type:mfa-totp';

    case ORGSELECTION = 'urn:workos:oauth:grant-type:organization-selection';
}
