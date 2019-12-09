<?php
namespace Translations\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Translations\Model\Table\LanguagesTable;
use Webmozart\Assert\Assert;

/**
 * Translations\Model\Table\LanguagesTable Test Case
 */
class LanguagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Translations\Model\Table\LanguagesTable
     */
    public $Languages;

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
        $config = TableRegistry::exists('Languages') ? [] : ['className' => 'Translations\Model\Table\LanguagesTable'];
        /**
         * @var \Translations\Model\Table\LanguagesTable $table
         */
        $table = TableRegistry::get('Languages', $config);
        $this->Languages = $table;

        // Load default plugin configuration
        Configure::load('Translations.translations');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Languages);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertInstanceOf(LanguagesTable::class, $this->Languages);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $validator = new Validator();
        $result = $this->Languages->validationDefault($validator);
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
        $result = $this->Languages->buildRules($rulesChecker);
        $this->assertTrue(is_object($result), 'buildRules() returned a non-object result');
        $this->assertEquals(get_class($result), get_class($rulesChecker));
    }

    /**
     * Test getRtl method
     *
     * @return void
     */
    public function testGetRtl(): void
    {
        $result = $this->Languages->getRtl();
        $this->assertTrue(is_array($result), 'getRtl() returned a non-array result');
        $this->assertFalse(empty($result), 'getRtl() returned empty result');

        // RTL languages
        $this->assertTrue(in_array('ar', $result), 'Arabic is missing from RTL languages');
        $this->assertTrue(in_array('he', $result), 'Hewbrew is missing from RTL languages');
        $this->assertTrue(in_array('fa', $result), 'Persian is missing from RTL languages');

        // LTR languages
        $this->assertFalse(in_array('en', $result), 'English found in RTL languages');
        $this->assertFalse(in_array('ru', $result), 'Russian found in RTL languages');
        $this->assertFalse(in_array('zh', $result), 'Chinese found in RTL languages');
    }

    /**
     * Locale/Langauge Provider
     *
     * @return mixed[]
     */
    public function localeLanguageProvider(): array
    {
        return [
            ['ru', 'ru'],
            ['RU', 'ru'],
            ['ru_RU', 'ru'],
            ['ru_RU.KOI8-R', 'ru'],
        ];
    }

    /**
     * Test localeToLanguage method
     *
     * @dataProvider localeLanguageProvider
     * @param string $locale Locale to test
     * @param string $expected Expected language
     * @return void
     */
    public function testLocaleToLanguage(string $locale, string $expected): void
    {
        $actual = $this->Languages->localeToLanguage($locale);
        $this->assertTrue(is_string($actual), 'localeToLanguage() returned a non-string result');
        $this->assertEquals($expected, $actual, "localeToLanguage() failed converting [$locale] to [$expected]. Got [$actual] instead");
    }

    /**
     * Test localeToLanguage method exception
     *
     * @expectedException \InvalidArgumentException
     * @return void
     */
    public function testLocaleToLanguageException(): void
    {
        // Send an empty string parameter
        $result = $this->Languages->localeToLanguage('');
    }

    /**
     * Langauge/RTL Provider
     *
     * @return mixed[]
     */
    public function languageRtlProvider(): array
    {
        return [
            ['ar', true],
            ['AR', true],
            ['ar_DZ', true],
            ['AR_DZ', true],
            ['ru', false],
            ['ru_RU', false],
            ['ru_RU.KOI8-R', false],
        ];
    }

    /**
     * Test isRtl method
     *
     * @dataProvider languageRtlProvider
     * @param string $language Language to test
     * @param bool $expected Expected result
     * @return void
     */
    public function testIsRtl(string $language, bool $expected): void
    {
        $actual = $this->Languages->isRtl($language);
        $this->assertTrue(is_bool($actual), 'isRtl() returned a non-boolean result');
        $this->assertEquals($expected, $actual, "isRtl() failed with [$language]");
    }

    /**
     * Test getSupported method
     *
     * @return void
     */
    public function testGetSupported(): void
    {
        $result = $this->Languages->getSupported();
        $this->assertTrue(is_array($result), 'getSupported() returned a non-array result');
        $this->assertFalse(empty($result), 'getSupported() returned empty result');

        $codes = array_keys($result);

        // RTL languages
        $this->assertTrue(in_array('ar', $codes), 'Arabic is missing from supported languages');
        $this->assertTrue(in_array('he', $codes), 'Hewbrew is missing from supported languages');
        $this->assertTrue(in_array('fa', $codes), 'Persian is missing from supported languages');

        // LTR languages
        $this->assertTrue(in_array('ru', $codes), 'Russian is missing from supported languages');
        $this->assertTrue(in_array('zh', $codes), 'Chinese is missing from supported languages');

        // English is system default, so shouldn't be in the list
        $this->assertFalse(in_array('en', $codes), 'English is found in supported languages');

        // All languages have label
        foreach ($result as $code => $label) {
            $this->assertTrue(is_string($label), "Label for code [$code] is not a string");
            $this->assertFalse(empty($label), "Label  for code [$code] is empty");
        }
    }

    /**
     * Test getAvailable method
     *
     * @return void
     */
    public function testGetAvailable(): void
    {
        $result = $this->Languages->getAvailable();
        $this->assertTrue(is_array($result), 'getAvailable() returned a non-array result');
        $this->assertFalse(empty($result), 'getAvailable() returned empty result');

        $codes = array_keys($result);

        // RTL languages
        $this->assertTrue(in_array('ar', $codes), 'Arabic is missing from available languages');
        $this->assertTrue(in_array('he', $codes), 'Hewbrew is missing from available languages');
        $this->assertTrue(in_array('fa', $codes), 'Persian is missing from available languages');

        // LTR languages
        $this->assertTrue(in_array('zh', $codes), 'Chinese is missing from available languages');

        // English is system default, so shouldn't be in the list
        $this->assertFalse(in_array('en', $codes), 'English is found in available languages');

        // Languages which are already added (db/fixture), shouldn't be in the list
        $this->assertFalse(in_array('ru', $codes), 'Russian is found in available languages');
        $this->assertFalse(in_array('de', $codes), 'German is found in available languages');

        // Languages which are in db/fixture, but trashed
        $this->assertTrue(in_array('it', $codes), 'Italian is missing from available languages');

        // All languages have label
        foreach ($result as $code => $label) {
            $this->assertTrue(is_string($label), "Label for code [$code] is not a string");
            $this->assertFalse(empty($label), "Label  for code [$code] is empty");
        }
    }

    /**
     * Test getName method
     *
     * @return void
     */
    public function testGetName(): void
    {
        $result = $this->Languages->getName('zh');
        $this->assertTrue(is_string($result), 'getName() returned a non-string result');
        $this->assertEquals('Chinese', $result, 'getName() returned a wrong value: ' . $result);
    }

    /**
     * Test getName method exception
     *
     * @expectedException \InvalidArgumentException
     * @return void
     */
    public function testGetNameException(): void
    {
        // Send an empty string parameter
        $result = $this->Languages->getName('');
    }

    /**
     * Test addOrRestore method exception
     *
     * @expectedException \InvalidArgumentException
     * @return void
     */
    public function testAddOrRestoreException(): void
    {
        // Send an empty array.  Anything without 'code' key.
        $result = $this->Languages->addOrRestore([]);
    }

    /**
     * Test addOrRestore method
     *
     * @return void
     */
    public function testAddOrRestore(): void
    {
        // Add Thai
        $result = $this->Languages->addOrRestore(['code' => 'th']);
        Assert::isInstanceOf($result, \Translations\Model\Entity\Language::class);
        $this->assertEquals('Thai', $result->name, 'testAddOrRestore() failed to set correct name');

        // Restore Italian
        $result = $this->Languages->addOrRestore(['code' => 'it']);
        Assert::isInstanceOf($result, \Translations\Model\Entity\Language::class);
        $this->assertEquals('Italian', $result->name, 'testAddOrRestore() failed to set correct name');
        $this->assertEquals(false, $result->trashed, 'testAddOrRestore() failed to set correct trashed');
    }
}
