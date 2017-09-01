<?php

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Translations\Event\Controller\Api\IndexActionListener;
use Translations\Event\View\ViewActionListener;

Configure::load('Translations.translations');

EventManager::instance()->on(new IndexActionListener());
EventManager::instance()->on(new ViewActionListener());
