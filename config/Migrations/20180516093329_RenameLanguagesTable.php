<?php
use Migrations\AbstractMigration;

class RenameLanguagesTable extends AbstractMigration
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
        $this->table('languages')
            ->rename('qobo_translations_languages');
    }
}
