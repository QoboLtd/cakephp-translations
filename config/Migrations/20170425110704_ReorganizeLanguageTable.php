<?php
use Migrations\AbstractMigration;

class ReorganizeLanguageTable extends AbstractMigration
{
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
        $table->addColumn('is_rtl', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('trashed', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('is_active', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->renameColumn('short_code', 'code');
        $table->removeColumn('description');
        $table->update();
    }
}
