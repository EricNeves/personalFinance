<?php

/**
 * Middlewares Association
 **/

return [
    'auth'       => \App\Adapters\In\Web\Middlewares\EnsureAuthenticatedMiddleware::class,
    'userExists' => \App\Adapters\In\Web\Middlewares\UserExistsMiddleware::class,
];