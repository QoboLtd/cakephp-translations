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
        $table = $this->table('language_translations');
        $table->addColumn('is_active', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
