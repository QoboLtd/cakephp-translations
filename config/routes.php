<?php
use Cake\Routing\Router;

Router::plugin(
    'Translations',
    ['path' => '/language-translations'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
