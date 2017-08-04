<?php
namespace Translations\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LanguagesFixture
 *
 */
class LanguagesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'code' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'is_rtl' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => false, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'UNIQUE_NAME' => ['type' => 'unique', 'columns' => ['code'], 'length' => []],
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
            'code' => 'ru',
            'name' => 'Russian',
            'created' => '2017-03-20 12:55:32',
            'modified' => '2017-03-20 12:55:32'
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000002',
            'code' => 'de',
            'name' => 'German',
            'created' => '2017-03-30 12:55:32',
            'modified' => '2017-03-30 12:55:32'
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000003',
            'code' => 'cn',
            'name' => 'Chinese',
            'created' => '2017-03-30 12:55:32',
            'modified' => '2017-03-30 12:55:32'
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000004',
            'code' => 'it',
            'name' => 'Italian',
            'trashed' => '2017-03-30 15:00:00',
            'created' => '2017-03-30 12:55:32',
            'modified' => '2017-03-30 12:55:32'
        ],
    ];
}
