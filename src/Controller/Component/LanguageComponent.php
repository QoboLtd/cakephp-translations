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
     * @var $rtl_languages
     */
    protected $rtl_languages = [];

    /**
     *  initialize method
     *
     */
    public function initialize(array $config)
    {
        $addedLanguages = TableRegistry::get('languages')
                            ->find('list', [
                                'keyField' => 'code',
                                'valueField' => 'code'
                            ])
                            ->toArray();

        foreach ((array)Configure::read('Translations.languages') as $key => $val) {
            if (empty($addedLanguages[$key])) {
                $this->languages[$key] = $val;
            }
        }
        $this->rtl_languages = (array)Configure::read('Translations.rtl_languages');
    }
}
