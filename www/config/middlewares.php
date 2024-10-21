<?php

/**
 * Middlewares Association
 **/

return [
    'auth' => \App\Adapters\In\Web\Middlewares\EnsureAuthenticatedMiddleware::class,
];