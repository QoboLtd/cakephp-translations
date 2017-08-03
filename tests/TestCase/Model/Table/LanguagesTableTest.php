<?php
namespace Translations\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Translations\Model\Table\LanguagesTable;

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
        'plugin.translations.translations'
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
        $this->Languages = TableRegistry::get('Languages', $config);

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
    public function testInitialize()
    {
        $this->assertInstanceOf(LanguagesTable::class, $this->Languages);
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

    /**
     * Test getRtl method
     *
     * @return void
     */
    public function testGetRtl()
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
     * @return array
     */
    public function localeLanguageProvider()
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
    public function testLocaleToLanguage($locale, $expected)
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
    public function testLocaleToLanguageException()
    {
        // Send a non-string parameter
        $result = $this->Languages->localeToLanguage(['ru']);
    }

    /**
     * Langauge/RTL Provider
     *
     * @return array
     */
    public function languageRtlProvider()
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
    public function testIsRtl($language, $expected)
    {
        $actual = $this->Languages->isRtl($language);
        $this->assertTrue(is_bool($actual), 'isRtl() returned a non-boolean result');
        $this->assertEquals($expected, $actual, "isRtl() failed with [$language]");
    }
}
