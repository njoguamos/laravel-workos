<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Enums;

enum AuthMethod: string
{
    case APPLE = "AppleOAuth";

    case GITHUB = "GitHubOAuth";

    case GOOGLE = "GoogleOAuth";

    case IMPERSONATOR = "Impersonation";

    case MAGIC = "MagicAuth";

    case MICROSOFT = "MicrosoftOAuth";

    case PASS = "Password";

    case SSO = "SSO";
}
