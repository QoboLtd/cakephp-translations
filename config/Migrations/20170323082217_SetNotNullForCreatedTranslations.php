<?php
use Migrations\AbstractMigration;

class SetNotNullForCreatedTranslations extends AbstractMigration
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
        if ($table->hasColumn('created')) {
            $table->changeColumn('created', 'datetime', [
                'default' => null,
                'null' => true
            ]);
        }
        if ($table->hasColumn('modified')) {
            $table->changeColumn('modified', 'datetime', [
                'default' => null,
                'null' => true
            ]);
        }
        $table->save();
    }
}
