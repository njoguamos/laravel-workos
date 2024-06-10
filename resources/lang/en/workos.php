<?php

declare(strict_types=1);

return [
    'exceptions' => [
        'api_key_is_missing'   => 'The Workos API Key is missing. Please set `WORKOS_API_KEY` in your `.env` file with a value from your Workos dashboard.',
        'client_id_is_missing' => 'The Workos Client ID is missing. Please set `WORKOS_CLIENT_ID` in your `.env` file with a value from your Workos dashboard.',

        'access_denied'                 => 'The user denied an OAuth authorization request at the identity provider.',
        'ambiguous_connection_selector' => 'A connection could not be uniquely identified using the provided connection selector (e.g., organization)',
        'connection_invalid'            => 'There is no connection for the provided ID.',
        'code_challenge_missing'        => "A code challenge method has been specified in the request, but a code challenge is missing. Please add the code challenge.",
        'connection_strategy_invalid'   => 'The provider has multiple strategies associated per environment.',
        'connection_unlinked'           => 'The connection associated with the request is unlinked.',
        'invalid_connection_selector'   => 'Valid connection selectors are either connection, organization, or provider.',
        'organization_invalid'          => 'There is no organization matching the provided ID.',
        'oauth_failed'                  => 'An OAuth authorization request failed for a user.',
        'redirect_uri_invalid'          => 'The redirect URI is invalid. Navigate to your Workos dashboard and check the correct Redirects URIs.',
        'server_error'                  => 'The SSO authentication failed for the user. More detailed errors and steps to resolve are available in the Sessions tab on the connection page in the WorkOS Dashboard.',

        'client_id_invalid' => 'The client ID is invalid. Please set `WORKOS_CLIENT_ID` in your `.env` file with a value from your Workos dashboard.',
    ]
];
