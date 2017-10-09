<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
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
     * @throws \InvalidArgumentException when locale is not a string
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

    /**
     * Get a list of supported language codes and labels
     *
     * @return array
     */
    public function getSupported()
    {
        $result = (array)Configure::read('Translations.languages');

        return $result;
    }

    /**
     * Get a list of all available languages
     *
     * Available languages are those that are in
     * configuration, but haven't yet been used for
     * an active language.
     *
     * @return array
     */
    public function getAvailable()
    {
        $result = [];

        $dbLanguages = $this->find('list', ['keyField' => 'code', 'valueField' => 'name'])
                            ->where(['trashed IS' => null])
                            ->toArray();
        $supportedLanguages = $this->getSupported();
        $result = array_diff_assoc($supportedLanguages, $dbLanguages);

        return $result;
    }

    /**
     * Get language name by code
     *
     * @throws \InvalidArgumentException when code is not a string
     * @param string $code Language code to lookup
     * @return string
     */
    public function getName($code)
    {
        $result = $code;

        if (!is_string($code)) {
            throw new InvalidArgumentException("Code must be string. " . gettype($code) . " given.");
        }

        $languages = $this->getSupported();
        if (!empty($languages[$code])) {
            $result = $languages[$code];
        }

        return $result;
    }

    /**
     * Add a new language or restore a deleted one
     *
     * @param array $data Language data to populate Entity with
     * @return \Cake\ORM\Entity
     */
    public function addOrRestore(array $data)
    {
        if (empty($data['code'])) {
            throw new InvalidArgumentException("Language data is missing 'code' key");
        }

        if (empty($data['is_rtl'])) {
            $data['is_rtl'] = $this->isRtl($data['code']);
        }

        if (empty($data['name'])) {
            $data['name'] = $this->getName($data['code']);
        }

        $deletedEntity = $this->find('onlyTrashed')
            ->where(['code' => $data['code']])
            ->first();

        if (!empty($deletedEntity)) {
            return $this->restoreTrash($deletedEntity);
        }

        $newEntity = $this->newEntity();
        $newEntity = $this->patchEntity($newEntity, $data);
        $result = $this->save($newEntity);

        return $result;
    }
}
