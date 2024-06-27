<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Enums;

enum Provider: string
{
    case AUTHKIT = 'authkit';

    case APPLE = 'AppleOAuth';

    case GOOGLE = 'GoogleOAuth';

    case MICROSOFT = 'MicrosoftOAuth';

    case GITHUB = 'GitHubOAuth';
}
