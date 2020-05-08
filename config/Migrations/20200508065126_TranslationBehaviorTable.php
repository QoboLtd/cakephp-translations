<?php
use Migrations\AbstractMigration;
use Cake\ORM\TableRegistry;

class TranslationBehaviorTable extends AbstractMigration
{
    /**
     * Rename translation colums for the translations behavior
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('qobo_translations_translations');
        $table->renameColumn('object_foreign_key', 'foreign_key');
        $table->renameColumn('object_model', 'model');
        $table->renameColumn('object_field', 'field');
        $table->renameColumn('translation', 'content');

        if (!$table->hasColumn('locale')) {
            $table->addColumn('locale', 'char', [
                'default' => null,
                'limit' => 6,
            ]);
        }
        $table->update();

        $table = TableRegistry::getTableLocator()->get("Translations.Translations");
        $entities = $table->find()->all();
        foreach($entities as $entity) {
            $entity->setDirty('locale', true);
            $table->save($entity);
        }
    }
    
    /**
     * Revert changes
     *
     * @return void
     */    
    public function down()
    {
        $table = $this->table('qobo_translations_translations');
        $table->renameColumn('foreign_key', 'object_foreign_key');
        $table->renameColumn('model', 'object_model');
        $table->renameColumn('field', 'object_field');
        $table->renameColumn('content', 'translation');
    }
}
