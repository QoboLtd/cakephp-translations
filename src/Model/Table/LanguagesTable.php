<?php
namespace Translations\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * Languages Model
 *
 * @property \Cake\ORM\Association\HasMany $Translations
 *
 */
class LanguagesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('languages');
        $this->setDisplayField('code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('Translations', [
            'foreignKey' => 'language_id',
            'className' => 'Translations.Translations'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('code', 'create')
            ->notEmpty('code')
            ->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['code']));

        return $rules;
    }

    /**
     * Convert locale to language
     *
     * On Linux, have a look at /usr/share/locale for the
     * list of possible locales and locale formats.
     *
     * @param string $locale Locale string (example: ru_RU.KOI8-R)
     * @return string Language (example: ru)
     */
    public function localeToLanguage($locale)
    {
        if (!is_string($locale)) {
            throw new InvalidArgumentException("Locale must be string. " . gettype($locale) . " given.");
        }

        // Truncate all, starting with underscore, at, or dot
        $result = preg_replace('/(_|@|\.).*$/', '', strtolower($locale));
        // Convert to lowercase for consistency
        $result = strtolower($result);

        return $result;
    }

    /**
     * Get a list of all right-to-left language codes
     *
     * @return array
     */
    public function getRtl()
    {
        $result = (array)Configure::read('Translations.rtl_languages');

        return $result;
    }

    /**
     * Check if given language is right-to-left
     *
     * @param string $language Language code or locale string (example: ru_RU.KOI8-R)
     * @return bool
     */
    public function isRtl($language)
    {
        $result = false;

        // Simplify and verify, just in case
        $language = $this->localeToLanguage($language);
        if (in_array($language, $this->getRtl())) {
            $result = true;
        }

        return $result;
    }
}
