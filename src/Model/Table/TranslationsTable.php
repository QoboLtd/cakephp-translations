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
        $this->belongsToMany('Phinxlog', [
            'foreignKey' => 'translation_id',
            'targetForeignKey' => 'phinxlog_id',
            'joinTable' => 'translations_phinxlog',
            'className' => 'Translations.Phinxlog'
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
}
