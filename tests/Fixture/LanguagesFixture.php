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
        'name' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'short_code' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'UNIQUE_NAME' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
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
            'name' => 'Russian',
            'short_code' => 'ru',
            'description' => 'Russian Language',
            'created' => '2017-03-20 12:55:32',
            'modified' => '2017-03-20 12:55:32'
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000002',
            'name' => 'German',
            'short_code' => 'de',
            'description' => 'German Language',
            'created' => '2017-03-30 12:55:32',
            'modified' => '2017-03-30 12:55:32'
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000003',
            'name' => 'Chinese',
            'short_code' => 'cn',
            'description' => 'Chinese Language',
            'created' => '2017-03-30 12:55:32',
            'modified' => '2017-03-30 12:55:32'
        ],
    ];
}
