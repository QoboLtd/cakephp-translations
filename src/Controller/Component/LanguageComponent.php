<?php

namespace Translations\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class LanguageComponent extends Component
{
    /**
     * @var $languages
     */
    protected $languages = [];

    /**
     * Initialize method
     *
     * @param array $config Options
     * @return void
     */
    public function initialize(array $config)
    {
        $table = TableRegistry::get('Translations.Languages');
        $this->languages = $table->getAll();
    }
}
