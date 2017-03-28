<?php
namespace Translations\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Translations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Languages
 * @property \Cake\ORM\Association\BelongsToMany $Phinxlog
 *
 */
class TranslationsTable extends Table
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

        $this->setTable('translations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Languages', [
            'foreignKey' => 'language_id',
            'joinType' => 'INNER',
            'className' => 'Translations.Languages'
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
            ->requirePresence('object_model', 'create')
            ->notEmpty('object_model');

        $validator
            ->requirePresence('object_foreign_key', 'create')
            ->notEmpty('object_foreign_key');

        $validator
            ->requirePresence('object_field', 'create')
            ->notEmpty('object_field');

        $validator
            ->requirePresence('translation', 'create')
            ->notEmpty('translation');

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
        $rules->add($rules->existsIn(['language_id'], 'Languages'));

        return $rules;
    }

    /**
     *  getTranslations
     *
     *  returns a list of translations existing for specified record and field. In case of passing
     * language the result will be filtered by it additionally
     *
     * @param string $modelName     model name
     * @param string $recordId      uuid of record the translated field belogns to
     * @param string $options       ID of the language used for translation
     * @return array                list of saved translations
     */
    public function getTranslations($modelName, $recordId, $options = [])
    {
        $conditions = [
            'object_model' => $modelName,
            'object_foreign_key' => $recordId
        ];

        if (!empty($options['language'])) {
            $conditions['language_id'] = $options['language'];
        }
        if (!empty($options['field'])) {
            $conditions['object_field'] = $options['field'];
        }
        $query = $this->find('all', [
            'conditions' => $conditions,
            'contain' => ['Languages'],
            'fields' => [
                'Translations.translation',
                'Translations.object_model',
                'Translations.object_field',
                'Translations.object_foreign_key',
                'Languages.short_code',
                'Languages.description',
            ],
        ]);
        if (!empty($options['toEntity'])) {
            return $query->first();
        } else {
            $query->hydrate(false);

            return $query->toList();
        }
    }

    /**
     *  addTranslation
     *  adding a new translation for specified language and field
     *
     * @param string $modelName          UUID record the translated field belongs to
     * @param string $recordId         translated field name
     * @param string $fieldName          language used for translation
     * @param string $language    Translated text
     * @return bool                     true in case of successfully saved translation and false otherwise
     */
    public function addTranslation($modelName, $recordId, $fieldName, $language, $translatedText)
    {
        $translationEntity = $this->newEntity();

        $translationEntity->object_model = $modelName;
        $translationEntity->object_field = $fieldName;
        $translationEntity->object_foreign_key = $recordId;
        $translationEntity->language_id = $this->getLanguageId($language);
        $translationEntity->translation = $translatedText;

        $result = $this->save($translationEntity);

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
        $translation = $this->get($recordId);
        $translation->translation = $translatedText;

        return $this->save($translation);
    }

    /**
     *  Retrive language ID by short code
     *
     * @param string $shortCode     language short code i.e. ru, cn etc
     * @return string               language's uuid
     */
    public function getLanguageId($shortCode)
    {
        $query = $this->Languages->find('all', [
            'conditions' => ['Languages.short_code' => $shortCode]
        ]);
        $language = $query->first();

        return !empty($language->id) ? $language->id : null;
    }
}
