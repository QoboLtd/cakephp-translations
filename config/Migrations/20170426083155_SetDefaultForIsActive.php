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
        $tableName = 'language_translations';
        if (!$this->hasTable($tableName)) {
            $tableName = 'translations';
        }

        $table = $this->table($tableName);
        if ($table->hasColumn('is_active')) {
            $table->changeColumn('is_active', 'boolean', [
                'default' => true,
                'null' => true,
            ]);
        }
        $table->update();
    }
}
