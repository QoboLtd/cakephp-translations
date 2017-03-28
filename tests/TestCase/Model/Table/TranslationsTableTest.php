<?php
namespace Translations\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Translations\Model\Table\TranslationsTable;

/**
 * Translations\Model\Table\TranslationsTable Test Case
 */
class TranslationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Translations\Model\Table\TranslationsTable
     */
    public $Translations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.translations.translations',
        'plugin.translations.languages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Translations') ? [] : ['className' => 'Translations\Model\Table\TranslationsTable'];
        $this->Translations = TableRegistry::get('Translations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Translations);

        parent::tearDown();
    }

    /**
     *  testGetTranslations method
     */
    public function testGetTranslations()
    {
        $result = $this->Translations->getTranslations(
            'Leads',
            '392f6284-2ae8-4667-9e70-40d012750161',
            [
                'language_id' => 'ae51d185-253e-40a2-804c-c71399099fe5',
            ]
        );
        $this->assertCount(1, $result);
        $this->assertEquals($result[0]['object_model'], 'Leads');
    }

    /**
     *  testAddTranslation method
     * @return void
     */
    public function testAddTranslation()
    {
        $params = [
            'object_model' => 'Leads',
            'object_field' => 'name',
            'object_foreign_key' => '133f6b2d-6129-4540-88ea-6130cad69d4f',
            'language' => 'ru',
            'translation' => 'Привет!',
        ];

        $result = $this->Translations->addTranslation(
            $params['object_model'],
            $params['object_foreign_key'],
            $params['object_field'],
            $params['language'],
            $params['translation']
        );

        $this->assertTrue($result);
    }

    /**
     *  testGetLanguageId method
     * @return void
     */
    public function testGetLanguageId()
    {
        $languageId = 'ae51d185-253e-40a2-804c-c71399099fe5';
        $shortCode = 'ru';
        $this->assertEquals($this->Translations->getLanguageId($shortCode), $languageId);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(TranslationsTable::class, new TranslationsTable);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
