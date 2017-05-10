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
        $table = $this->table('language_translations');
        $table->changeColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->changeColumn('modified', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->save();
    }
}
