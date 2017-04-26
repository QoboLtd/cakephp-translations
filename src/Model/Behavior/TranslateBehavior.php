<?php

namespace Translations\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;

/**
 *  TranslateBehavior
 *
 *  Contains methods to manage translations
 */
class TranslateBehavior extends Behavior
{
    /**
     *  Translation table instance
     */
    protected $_translationsTable = null;

    /**
     *  Language table instance
     */
    protected $_languagesTable = null;

    /**
     *  Initialization
     *
     * @param array $config     configuation parameters
     * @return void
     */
    public function initialize(array $config)
    {
        $this->_translationsTable = TableRegistry::get('Translations');
        $this->_languagesTable = TableRegistry::get('Languages');
    }

    /**
     *  getTranslations
     *
     *  returns a list of translations existing for specified record and field. In case of passing
     * language the result will be filtered by it additionally
     *
     * @param string $modelName     model name
     * @param string $recordId      uuid of record the translated field belogns to
     * @param string $fieldName     translated field name
     * @param string $language      ID of the language used for translation
     * @return array                list of saved translations
     */
    public function getTranslations($modelName, $recordId, $fieldName, $language = null)
    {
        $conditions = [
            'object_model' => $modelName,
            'object_field' => $fieldName,
            'object_foreign_key' => $recordId
        ];

        if (!empty($language)) {
            $conditions['language_id'] = $language;
        }
        debug($this->_translationsTable->associations());
        $query = $this->_translationsTable->find('all', [
            'conditions' => $conditions,
            //'contain' => ['Languages']
        ]);
        $query->hydrate(false);

        return $query->toList();
    }

    /**
     *  addTranslation
     *  adding a new translation for specified language and field
     *
     * @param string $recordId          UUID record the translated field belongs to
     * @param string $fieldName         translated field name
     * @param string $language          language used for translation
     * @param string $translatedText    Translated text
     * @return bool                     true in case of successfully saved translation and false otherwise
     */
    public function addTranslation($recordId, $fieldName, $language, $translatedText)
    {
        $translationEntity = $this->_translationsTable->newEntity();

        $translationEntity->object_model = $this->getTable()->alias();
        $translationEntity->object_field = $fieldName;
        $translationEntity->object_foreign_key = $recordId;
        $translationEntity->language_id = $this->getLanguageId($language);
        $translationEntity->translation = $translatedText;

        $result = $this->_translationsTable->save($translationEntity);

        return !empty($result->id) ? true : false;
    }

    /**
     *  updateTranslation
     *
     *  updates existing translation
     *
     * @param string $recordId          UUID translation
     * @param string $fieldName         translated field name
     * @param string $language          language used for translation
     * @param string $translatedText    Translated text
     * @return bool                     true in case of successfully saved translation and false otherwise
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function updateTranslation($recordId, $fieldName, $language, $translatedText)
    {
        $translation = $this->_translationsTable->get($recordId);
        $translation->translation = $translatedText;

        return $this->_translationsTable->save($translation);
    }

    /**
     *  Retrive language ID by code
     *
     * @param string $shortCode     language short code i.e. ru, cn etc
     * @return string          language's uuid
     */
    public function getLanguageId($shortCode)
    {
        $query = $this->_languagesTable->find('all', [
            'conditions' => ['Languages.code' => $shortCode]
        ]);
        $language = $query->first();

        return !empty($language->id) ? $language->id : null;
    }
}
