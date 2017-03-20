<?php
use Migrations\AbstractMigration;

class CreateLanguages extends AbstractMigration
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
        $table = $this->table('languages');
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'null' => false,
            'limit' => 20,
        ]);
        $table->addColumn('short_code', 'string', [
            'default' => null,
            'null' => false,
            'limit' => 6,
        ]);
        $table->addColumn('description', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 255,
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
        $table->addIndex([
            'name',
        ], [
            'name' => 'UNIQUE_NAME',
            'unique' => true,
        ]);

        $table->create();
    }
}
