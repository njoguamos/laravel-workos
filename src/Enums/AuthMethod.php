<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkos\Enums;

enum AuthMethod: string
{
    case SSO = "SSO";
    case PASS = "Password";
    case GITHUB = "GitHubOAuth";
    case GOOGLE = "GoogleOAuth";
    case MICROSOFT = "MicrosoftOAuth";
    case MAGIC = "MagicAuth";
    case IMPERSONATOR = "Impersonation";
}
