<?php
namespace Qobo\Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Translations\Controller\LanguagesController;

/**
 * Qobo\Translations\Controller\LanguagesController Test Case
 *
 * @property \Qobo\Translations\Model\Table\LanguagesTable $Languages
 */
class LanguagesControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.qobo/translations.languages'
    ];

    public function setUp()
    {
        parent::setUp();

        /**
         * @var \Qobo\Translations\Model\Table\LanguagesTable $table
         */
        $table = TableRegistry::get('Translations.Languages');
        $this->Languages = $table;

        // Run all tests as authenticated user
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '00000000-0000-0000-0000-000000000001',
                ],
            ],
        ]);

        // Load default plugin configuration
        Configure::load('Qobo/Translations.translations');
    }

    public function tearDown()
    {
        unset($this->Languages);

        parent::tearDown();
    }

    public function testIndex(): void
    {
        $this->get('/language-translations/languages');
        $this->assertResponseOk();
    }

    public function testAddGet(): void
    {
        $this->get('/language-translations/languages/add');
        $this->assertResponseOk();
    }

    public function testAddPost(): void
    {
        $data = ['code' => 'el_CY'];
        $this->post('/language-translations/languages/add', $data);
        $this->assertRedirect();

        $query = $this->Languages->find()->where($data);

        $this->assertFalse($query->isEmpty());
        $this->assertEquals(1, $query->count());
        /**
         * @var \Qobo\Translations\Model\Entity\Language $first
         */
        $first = $query->first();
        $this->assertEquals('Greek (Cyprus)', $first->get('name'));
    }

    public function testDelete(): void
    {
        $this->post('/language-translations/languages/delete/00000000-0000-0000-0000-000000000001', []);
        $this->assertRedirect(['controller' => 'Languages', 'action' => 'index']);
    }
}
