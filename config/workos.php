<?php

declare(strict_types=1);

return [

    /*
     * --------------------------------------------------------------------------
     * The WorkOS API Key.
     * --------------------------------------------------------------------------
     *
     * This is the API key used to authenticate requests to the WorkOS API. You
     * can find your API key in the WorkOS dashboard. API keys are prefixed
     * with sk_. Make sure to use Staging Key for testing and Production Key
     * for production environments.
     *
     */
    'api_key' => env(key: 'WORKOS_API_KEY'),

    /*
     * --------------------------------------------------------------------------
     * The WorkOS Client ID.
     * --------------------------------------------------------------------------
     *
     * This is the Client ID used to authenticate requests to the WorkOS API. You
     * can find your Client ID in the WorkOS dashboard. Client ID are prefixed
     * with client_. Make sure to use Staging Client ID for testing and
     * Production Client ID for production environments.
     *
     */
    'client_id' => env(key: 'WORKOS_CLIENT_ID'),

    /*
     * --------------------------------------------------------------------------
     * The WorkOS Base URL.
     * --------------------------------------------------------------------------
     *
     * This is the base URL for the WorkOS API. By default, this is set to the
     * production API URL. You can override this by setting the WORKOS_API_BASE_URL
     * environment variable.
     *
     */
    'api_base_url' => env(key: 'WORKOS_API_BASE_URL', default: 'https://api.workos.com'),
];
