<?php
namespace Translations\Test\App\Config;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

// Load all plugin routes. See the Plugin documentation on how to customize the loading of plugin routes.
Plugin::routes();

Router::connect('/users/login', ['controller' => 'Users', 'action' => 'login']);

// Add api route to handle our REST API functionality
Router::prefix('api', function ($routes) {
    // handle json file extension on API calls
    $routes->extensions(['json']);

    $routes->resources('Translations');

    $routes->fallbacks('DashedRoute');
});
