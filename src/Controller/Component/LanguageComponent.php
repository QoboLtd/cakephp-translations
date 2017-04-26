<?php

namespace Translations\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;

class LanguageComponent extends Component
{
    /**
     * @var $languages
     */
    protected $languages = [];

    /**
     *  initialize method
     *
     */
    public function initialize(array $config)
    {
        $this->languages = (array)Configure::read('Translations.languages');
    }
}
