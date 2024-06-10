<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Enums;

enum Provider: string
{
    case AUTHKIT = 'authkit';

    case GOOGLE = 'GoogleOAuth';

    case MICROSOFT = 'MicrosoftOAuth';

    case GITHUB = 'GitHubOAuth';
}
