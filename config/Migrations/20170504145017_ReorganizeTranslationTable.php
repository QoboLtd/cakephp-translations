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
        $table = $this->table('language_translations');
        $table->removeColumn('is_active');
        $table->removeColumn('code');
        $table->addColumn('language_id', 'string', [
            'limit' => 36,
            'null' => false,
        ]);
        $table->save();
    }
}
