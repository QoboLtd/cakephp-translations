<?php
use Migrations\AbstractMigration;

class RenameTranslationsTable extends AbstractMigration
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
        $tableName = 'translations';
        $columnName = 'object_foreign_key';

        if ($this->hasTable($tableName)) {
            $table = $this->table($tableName);

            if ($table->hasColumn($columnName)) {
                $table->rename('language_translations');
            }
        }
    }
}
