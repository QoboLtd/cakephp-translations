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
     * Initialize method
     *
     * @param array $config Options
     * @return void
     */
    public function initialize(array $config)
    {
        $table = TableRegistry::get('languages');
        $query = $table->find('list', [
                                'keyField' => 'code',
                                'valueField' => 'code'
                            ])
                            ->where(['trashed IS' => null]);
        $addedLanguages = $query->toArray();
        foreach ((array)Configure::read('Translations.languages') as $key => $val) {
            if (empty($addedLanguages[$key])) {
                $this->languages[$key] = $val;
            }
        }
        $this->rtl_languages = (array)Configure::read('Translations.rtl_languages');
    }
}
