<?php
use Migrations\AbstractMigration;

class AddIsActiveFlagToTranslations extends AbstractMigration
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
        if (!$table->hasColumn('is_active')) {
            $table->addColumn('is_active', 'boolean', [
                'default' => 0,
                'null' => false,
            ]);
        }
        $table->update();
    }
}
