<?php
namespace Translations\Test\TestCase\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Translations\Model\Entity\Translation;
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
        'plugin.translations.languages',
        'plugin.translations.language_translations',
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
        /**
         * @var \Translations\Model\Table\TranslationsTable $table
         */
        $table = TableRegistry::get('Translations', $config);
        $this->Translations = $table;
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
    public function testGetTranslations(): void
    {
        $modelName = 'Leads';
        $recordId = '00000000-0000-0000-0000-100000000001';

        $result = $this->Translations->getTranslations($modelName, $recordId);

        $this->assertInternalType('array', $result);
        if (is_array($result)) {
            $this->assertEquals(3, count($result));
            $this->assertEquals($result[0]['object_model'], 'Leads');
        }
    }

    public function testGetTranslationsWithLanguageId(): void
    {
        $modelName = 'Leads';
        $recordId = '00000000-0000-0000-0000-100000000001';
        $languageId = '00000000-0000-0000-0000-000000000001';

        $result = $this->Translations->getTranslations($modelName, $recordId, [
            'language' => $languageId,
        ]);
        $this->assertTrue(is_array($result), "getTranslations() returned a non-array result");
        if (is_array($result)) {
            $this->assertEquals(2, count($result));
        }
    }

    public function testGetTranslationsWithObjectField(): void
    {
        $modelName = 'Leads';
        $recordId = '00000000-0000-0000-0000-100000000001';
        $objectField = 'description';

        $result = $this->Translations->getTranslations($modelName, $recordId, [
            'field' => $objectField,
        ]);
        $this->assertTrue(is_array($result), "getTranslations() returned a non-array result");
        if (is_array($result)) {
            $this->assertEquals(2, count($result));
        }
    }

    public function testGetTranslationsAsEntity(): void
    {
        $modelName = 'Leads';
        $recordId = '00000000-0000-0000-0000-100000000001';

        $result = $this->Translations->getTranslations($modelName, $recordId, [
            'toEntity' => true,
        ]);

        $this->assertInstanceOf(Translation::class, $result);
    }

    /**
     *  testAddTranslation method
     * @return void
     */
    public function testAddTranslation(): void
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
    public function testGetLanguageId(): void
    {
        $languageId = '00000000-0000-0000-0000-000000000001';
        $shortCode = 'ru';
        $this->assertEquals($this->Translations->getLanguageId($shortCode), $languageId);
    }

    public function testGetLanguageIdWithUnsupportedId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->Translations->getLanguageId('foobar');
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertInstanceOf(TranslationsTable::class, new TranslationsTable());
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $validator = new Validator();
        $result = $this->Translations->validationDefault($validator);
        $this->assertTrue(is_object($result), 'validationDefault() returned a non-object result');
        $this->assertEquals(get_class($result), get_class($validator));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $rulesChecker = new RulesChecker();
        $result = $this->Translations->buildRules($rulesChecker);
        $this->assertTrue(is_object($result), 'buildRules() returned a non-object result');
        $this->assertEquals(get_class($result), get_class($rulesChecker));
    }
}
