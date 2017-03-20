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
        'plugin.translations.objects',
        'plugin.translations.phinxlog',
        'plugin.translations.translations_phinxlog'
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
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
