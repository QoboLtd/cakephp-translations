<?php
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateTranslations extends AbstractMigration
{
    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        if ($this->hasTable('language_translations')) {
            return;
        }

        $table = $this->table('language_translations');
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('language_id', 'char', [
            'default' => null,
            'null' => false,
            'limit' => 36,
        ]);
        $table->addColumn('object_foreign_key', 'char', [
            'default' => null,
            'null' => false,
            'limit' => 36,
        ]);
        $table->addColumn('object_model', 'string', [
            'default' => null,
            'null' => false,
            'limit' => 128,
        ]);
        $table->addColumn('object_field', 'string', [
            'default' => null,
            'null' => false,
            'limit' => 128,
        ]);
        $table->addColumn('translation', 'text', [
            'default' => null,
            'null' => false,
            'limit' => MysqlAdapter::TEXT_LONG,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addPrimaryKey([
            'id',
        ]);

        $table->create();
    }
}
