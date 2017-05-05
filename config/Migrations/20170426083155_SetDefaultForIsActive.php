<?php
use Migrations\AbstractMigration;

class SetDefaultForIsActive extends AbstractMigration
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
        $table = $this->table('translations');
        $table->changeColumn('is_active', 'boolean', [
            'default' => true,
            'null' => true,
        ]);
        $table->update();
    }
}
