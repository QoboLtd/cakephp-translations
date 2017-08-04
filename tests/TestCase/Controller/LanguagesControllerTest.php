<?php
namespace Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;
use Translations\Controller\LanguagesController;

/**
 * Translations\Controller\LanguagesController Test Case
 */
class LanguagesControllerTest extends IntegrationTestCase
{

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
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.translations.languages'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/language-translations/languages');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/language-translations/languages/add');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->post('/language-translations/languages/delete/00000000-0000-0000-0000-000000000001', []);
        $this->assertRedirect(['controller' => 'Languages', 'action' => 'index']);
    }
}
