<?php

declare(strict_types=1);

return [

    /*
     | --------------------------------------------------------------------------
     | The WorkOS API Key.
     | --------------------------------------------------------------------------
     |
     | This is the API key used to authenticate requests to the WorkOS API. You
     | can find your API key in the WorkOS dashboard. API keys are prefixed
     | with sk_. Make sure to use Staging Key for testing and Production Key
     | for production environments.
     |
     */
    'api_key' => env(key: 'WORKOS_API_KEY'),

    /*
     | --------------------------------------------------------------------------
     | The WorkOS Client ID.
     | --------------------------------------------------------------------------
     |
     | This is the Client ID used to authenticate requests to the WorkOS API. You
     | can find your Client ID in the WorkOS dashboard. Client ID are prefixed
     | with client_. Make sure to use Staging Client ID for testing and
     | Production Client ID for production environments.
     |
     */
    'client_id' => env(key: 'WORKOS_CLIENT_ID'),

    /*
     | --------------------------------------------------------------------------
     | The WorkOS Base URL.
     | --------------------------------------------------------------------------
     |
     | This is the base URL for the WorkOS API. At the time of writing this
     | the base URL is https://api.workos.com. If the base URL changes in the
     | future, you can update it here.
     |
     */
    'api_base_url' => 'https://api.workos.com',


    /*
     | --------------------------------------------------------------------------
     | Cache Driver
     | --------------------------------------------------------------------------
     |
     | This option controls the default cache store that will be used by the
     | package to store rate limits. By default, the cache driver is set to
     | your Laravel application's cache driver or `array` if not set.
     |
     */
    'cache_store' => env(key: 'WORKOS_CACHE_DRIVER', default: env(key: 'CACHE_DRIVER', default: 'array'))
];
