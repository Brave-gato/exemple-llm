<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),

    'groq_api_key' => env('GROQ_API_KEY'),
    'groq_organization' => env('GROQ_ORGANIZATION'),
    'groq_api_endpoint' => env('GROQ_BASE_URL', 'https://api.groq.com/openai/v1'),

    'anyscale_api_key' => env('ANYSCALE_API_KEY'),
    'anyscale_organization' => env('ANYSCALE_ORGANIZATION'),
    'anyscale_api_endpoint' => env('ANYSCALE_BASE_URL', 'https://api.groq.com/openai/v1'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),
];
