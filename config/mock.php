<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Max number of mock APIs that a user can create
    |--------------------------------------------------------------------------
    |
    | This value determines the maximum number of mock APIs that a user can
    | create. If the user has reached this limit, they will not be able to
    | create any more mock APIs.
    |
    */

    'max_mock_apis' => (int) env('MAX_MOCK_APIS', 5),

    /*
    |--------------------------------------------------------------------------
    | Default number of mock API resouces
    |--------------------------------------------------------------------------
    |
    | This value determines the default number of resouces that a mock API
    | will have when it is created. This value can be overridden when creating
    | a mock API.
    |
    */

    'default_mock_api_resources' => (int) env('DEFAULT_MOCK_API_RESOURCES', 10),
];
