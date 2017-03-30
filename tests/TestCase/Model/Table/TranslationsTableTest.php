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
            '00000000-0000-0000-0000-100000000001',
            [
                'language_id' => '00000000-0000-0000-0000-000000000001',
            ]
        );
        debug($result);
        $this->assertEquals(3, count($result));
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
            'object_foreign_key' => '00000000-0000-0000-1000-000000000001',
            'language' => 'ru',
            'translation' => 'Test',
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
        $languageId = '00000000-0000-0000-0000-000000000001';
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
