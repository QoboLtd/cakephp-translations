<?php
namespace Translations\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LanguageTranslationsFixture
 *
 */
class LanguageTranslationsFixture extends TestFixture
{
    public $table = 'qobo_translations_translations';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'language_id' => ['type' => 'string', 'fixed' => true, 'length' => 36, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'foreign_key' => ['type' => 'string', 'fixed' => true, 'length' => 36, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'model' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'field' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'content' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '00000000-0000-0000-0000-000000000001',
            'language_id' => '00000000-0000-0000-0000-000000000001',
            'foreign_key' => '00000000-0000-0000-0000-100000000001',
            'model' => 'Leads',
            'field' => 'description',
            'content' => 'This is a test.',
            'created' => '2017-03-20 12:56:37',
            'modified' => '2017-03-20 12:56:37',
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000002',
            'language_id' => '00000000-0000-0000-0000-000000000001',
            'foreign_key' => '00000000-0000-0000-0000-100000000001',
            'model' => 'Leads',
            'field' => 'code',
            'content' => 'This is a test.',
            'created' => '2017-03-20 12:56:37',
            'modified' => '2017-03-20 12:56:37',
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000003',
            'language_id' => '00000000-0000-0000-0000-000000000002',
            'foreign_key' => '00000000-0000-0000-0000-100000000001',
            'model' => 'Leads',
            'field' => 'description',
            'content' => 'This is a test.',
            'created' => '2017-03-20 12:56:37',
            'modified' => '2017-03-20 12:56:37',
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000004',
            'language_id' => '00000000-0000-0000-0000-000000000002',
            'foreign_key' => '00000000-0000-0000-0000-100000000002',
            'model' => 'Leads',
            'field' => 'title',
            'content' => 'This is a test.',
            'created' => '2017-03-20 12:56:37',
            'modified' => '2017-03-20 12:56:37',
        ],
    ];
}
