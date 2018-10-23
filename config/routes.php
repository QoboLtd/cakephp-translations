<?php
use Cake\Routing\Router;

Router::plugin(
    'Qobo/Translations',
    ['path' => '/language-translations'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
