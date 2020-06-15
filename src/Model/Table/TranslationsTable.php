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

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use InvalidArgumentException;

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

        $this->setTable('qobo_translations_translations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Languages', [
            'foreignKey' => 'language_id',
            'joinType' => 'INNER',
            'className' => 'Translations.Languages',
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
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->requirePresence('foreign_key', 'create')
            ->notEmpty('foreign_key');

        $validator
            ->requirePresence('field', 'create')
            ->notEmpty('field');

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
     * @param mixed[] $options      ID of the language used for translation
     * @return \Translations\Model\Entity\Translation|array|null single record or list of saved translations
     */
    public function getTranslations(string $modelName, string $recordId, array $options = [])
    {
        $conditions = [
            'model' => $modelName,
            'foreign_key' => $recordId,
        ];

        if (!empty($options['language'])) {
            $conditions['language_id'] = $options['language'];
        }
        if (!empty($options['field'])) {
            $conditions['field'] = $options['field'];
        }
        $query = $this->find('all', [
            'conditions' => $conditions,
            'contain' => ['Languages'],
            'fields' => [
                'Translations.id',
                'Translations.content',
                'Translations.model',
                'Translations.field',
                'Translations.foreign_key',
                'Languages.code',
            ],
        ]);
        if (!empty($options['toEntity'])) {
            /**
             * @var \Translations\Model\Entity\Translation $entity
             */
            $entity = $query->first();

            return $entity;
        } else {
            $query->enableHydration(false);

            return $query->toList();
        }
    }

    /**
     * addTranslation
     *
     * adding a new translation for specified language and field
     *
     * @param string $modelName          UUID record the translated field belongs to
     * @param string $recordId         translated field name
     * @param string $fieldName          language used for translation
     * @param string $language    Language
     * @param string $translatedText Translated text
     * @return bool                     true in case of successfully saved translation and false otherwise
     */
    public function addTranslation(string $modelName, string $recordId, string $fieldName, string $language, string $translatedText): bool
    {
        /**
         * @var \Translations\Model\Entity\Translation $translationEntity
         */
        $translationEntity = $this->newEntity();

        $translationEntity->model = $modelName;
        $translationEntity->field = $fieldName;
        $translationEntity->foreign_key = $recordId;
        $translationEntity->language_id = $this->getLanguageId($language);
        $translationEntity->content = $translatedText;

        $result = $this->save($translationEntity);

        return !empty($result->id) ? true : false;
    }

    /**
     * If the TranslationBehavior is in use, it updates the `language_id` or viceversa, the `locale`.
     *
     * @param Event $event Event
     * @param EntityInterface $entity Entity
     * @param ArrayObject $options Options
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options): void
    {
        // No need to update the fields if the entity already exist.
        if (!$entity->isNew()) {
            return;
        }

        if (empty($entity->get("language_id"))) {
            $entity->set('language_id', $this->getLanguageId($entity->get("locale")));
        }

        if (empty($entity->get("locale"))) {
            $entity->set('locale', $this->getLanguageCode($entity->get("language_id")));
        }
    }

    /**
     *  Retrive language ID by code
     *
     * @throws \InvalidArgumentException for unknown short code
     * @param string $shortCode     language code i.e. ru, cn etc
     * @return string              language's uuid
     */
    public function getLanguageId(string $shortCode): string
    {
        $query = $this->Languages->find('all', [
            'conditions' => ['Languages.code' => $shortCode],
        ]);
        $language = $query->first();

        if (empty($language->id)) {
            throw new InvalidArgumentException("Unsupported language code [$shortCode]");
        }

        return $language->id;
    }

    /**
     *  Retrive language ID by code
     *
     * @throws \InvalidArgumentException for unknown short code
     * @param string $id language's uuid
     * @return string language code i.e. ru, cn etc
     */
    public function getLanguageCode(string $id): string
    {
        $query = $this->Languages->find('all', [
            'conditions' => ['Languages.id' => $id],
        ]);
        $language = $query->first();

        if (empty($language->id)) {
            throw new InvalidArgumentException("Unsupported language id [$id]");
        }

        return $language->get("code");
    }
}
