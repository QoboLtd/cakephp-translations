<?php

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Translations\Event\IndexViewListener;

Configure::load('Translations.translations');

EventManager::instance()->on(new IndexViewListener());
