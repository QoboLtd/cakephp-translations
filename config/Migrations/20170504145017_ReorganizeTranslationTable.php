<?php
use Migrations\AbstractMigration;

class ReorganizeTranslationTable extends AbstractMigration
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
            $table->removeColumn('is_active');
        }
        if ($table->hasColumn('code')) {
            $table->removeColumn('code');
        }
        if ($table->hasColumn('language_id')) {
            $table->changeColumn('language_id', 'string', [
                'limit' => 36,
                'null' => false,
            ]);
        } else {
            $table->addColumn('language_id', 'string', [
                'limit' => 36,
                'null' => false,
            ]);
        }
        $table->save();
    }
}
