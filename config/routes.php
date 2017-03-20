<?php

use Cake\Routing\Router;

Router::plugin(
    'Translations',
    ['path' => '/translations'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
