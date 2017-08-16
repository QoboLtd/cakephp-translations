<?php

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Translations\Event\Controller\Api\IndexActionListener;

Configure::load('Translations.translations');

EventManager::instance()->on(new IndexActionListener());
