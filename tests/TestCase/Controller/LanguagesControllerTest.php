<?php
namespace Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Translations\Controller\LanguagesController;

/**
 * Translations\Controller\LanguagesController Test Case
 */
class LanguagesControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.translations.languages'
    ];

    public function setUp()
    {
        parent::setUp();

        $this->Languages = TableRegistry::get('Translations.Languages');

        // Run all tests as authenticated user
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '00000000-0000-0000-0000-000000000001',
                ],
            ],
        ]);

        // Load default plugin configuration
        Configure::load('Translations.translations');
    }

    public function tearDown()
    {
        unset($this->Languages);

        parent::tearDown();
    }

    public function testIndex()
    {
        $this->get('/language-translations/languages');
        $this->assertResponseOk();
    }

    public function testAddGet()
    {
        $this->get('/language-translations/languages/add');
        $this->assertResponseOk();
    }

    public function testAddPost()
    {
        $data = ['code' => 'el_CY'];
        $this->post('/language-translations/languages/add', $data);
        $this->assertRedirect();

        $query = $this->Languages->find()->where($data);

        $this->assertFalse($query->isEmpty());
        $this->assertEquals(1, $query->count());
        $this->assertEquals('Greek (Cyprus)', $query->first()->get('name'));
    }

    public function testDelete()
    {
        $this->post('/language-translations/languages/delete/00000000-0000-0000-0000-000000000001', []);
        $this->assertRedirect(['controller' => 'Languages', 'action' => 'index']);
    }
}
