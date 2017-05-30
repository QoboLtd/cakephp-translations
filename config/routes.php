<?php

use Cake\Routing\Router;

Router::plugin(
    'Translations',
    ['path' => '/language-translations'],
    function ($routes) {
        $routes->prefix('api', function ($routes) {
            /**
             * handle json file extension on API calls
             */
            $routes->extensions(['json']);
            $routes->resources('Translations');
        });
        $routes->fallbacks('DashedRoute');
    }
);
