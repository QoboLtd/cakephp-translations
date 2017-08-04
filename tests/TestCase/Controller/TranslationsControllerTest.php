<?php
namespace Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;
use Translations\Controller\TranslationsController;

/**
 * Translations\Controller\TranslationsController Test Case
 */
class TranslationsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.translations.languages',
        'plugin.translations.language_translations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
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

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/language-translations/translations');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/language-translations/translations/view/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/language-translations/translations/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/language-translations/translations/edit/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->post('/language-translations/translations/delete/00000000-0000-0000-0000-000000000001', []);
        $this->assertRedirect(['controller' => 'Translations', 'action' => 'index']);
    }
}
