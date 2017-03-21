<?php
use Migrations\AbstractMigration;

class AddIsActiveFlagToLanguages extends AbstractMigration
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
        $table->addColumn('is_active', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
