<?php
namespace Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Translations\Controller\TranslationsController Test Case
 *
 * @property \Translations\Model\Table\TranslationsTable $Translations
 */
class TranslationsControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.translations.languages',
        'plugin.translations.language_translations'
    ];

    public function setUp()
    {
        parent::setUp();

        /**
         * @var \Translations\Model\Table\TranslationsTable $table
         */
        $table = TableRegistry::get('Translations.Translations');
        $this->Translations = $table;

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

        $this->enableRetainFlashMessages();
    }

    public function tearDown()
    {
        unset($this->Translations);

        parent::tearDown();
    }

    public function testIndex(): void
    {
        $this->get('/language-translations/translations');
        $this->assertResponseOk();
    }

    public function testIndexJson(): void
    {
        $this->get('/language-translations/translations?json=1&object_model=Leads&object_foreign_key=00000000-0000-0000-0000-100000000001');
        $this->assertResponseOk();
    }

    public function testView(): void
    {
        $this->get('/language-translations/translations/view/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $expected = 1 + $this->Translations->find('all')->count();

        $data = [
            'language_id' => '00000000-0000-0000-0000-000000000001',
            'object_foreign_key' => '00000000-0000-0000-0000-100000000001',
            'object_model' => 'Leads',
            'object_field' => 'description',
            'translation' => 'Russian translation.',
        ];

        $this->post('/language-translations/translations/add', $data);

        $url = [
            'plugin' => 'Translations',
            'controller' => 'Translations',
            'action' => 'index'
        ];
        $this->assertRedirect($url);

        $this->assertEquals($expected, $this->Translations->find('all')->count());
    }

    public function testAddMissingData(): void
    {
        $expected = $this->Translations->find('all')->count();

        $data = [
            'language_id' => '00000000-0000-0000-0000-000000000001',
            'object_foreign_key' => '00000000-0000-0000-0000-100000000001',
            'object_model' => 'Leads',
            'object_field' => 'description',
            // 'translation' => 'Russian translation.',
        ];

        $this->post('/language-translations/translations/add', $data);
        $this->assertResponseOk();

        $this->assertEquals($expected, $this->Translations->find('all')->count());
        $this->assertSession('The translation could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    public function testAddInvalidData(): void
    {
        $expected = $this->Translations->find('all')->count();

        $data = [
            // invalid lanuage id
            'language_id' => '00000000-0000-0000-0000-000000000999',
            'object_foreign_key' => '00000000-0000-0000-0000-100000000001',
            'object_model' => 'Leads',
            'object_field' => 'description',
            'translation' => 'Russian translation.',
        ];

        $this->post('/language-translations/translations/add', $data);
        $this->assertResponseOk();

        $this->assertEquals($expected, $this->Translations->find('all')->count());
        $this->assertSession('The translation could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    public function testAddNoData(): void
    {
        $expected = $this->Translations->find('all')->count();
        $this->post('/language-translations/translations/add');
        $this->assertResponseOk();

        $this->assertEquals($expected, $this->Translations->find('all')->count());
        $this->assertSession('The translation could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    public function testAddGet(): void
    {
        $this->get('/language-translations/translations/add');
        $this->assertResponseOk();
    }

    public function testAddOrUpdate(): void
    {
        $this->configRequest([
            'headers' => [
                // link: http://discourse.cakephp.org/t/solved-cakephp3-how-to-test-ajax-actions/948
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            'object_model' => 'Leads',
            'object_field' => 'description',
            'translation' => 'Chinese translation.',
            'language_id' => '00000000-0000-0000-0000-000000000003',
            'object_foreign_key' => '00000000-0000-0000-0000-100000000001'
        ];

        $this->post('/language-translations/translations/add-or-update', $data);

        $this->assertResponseOk();
    }

    public function testAddOrUpdateNonAjax(): void
    {
        $this->post('/language-translations/translations/add-or-update');

        $this->assertResponseFailure();
    }

    public function testEdit(): void
    {
        $id = '00000000-0000-0000-0000-000000000001';

        $data = [
            'translation' => 'Modify translation.',
        ];

        $this->post('/language-translations/translations/edit/' . $id, $data);

        $url = [
            'plugin' => 'Translations',
            'controller' => 'Translations',
            'action' => 'index'
        ];
        $this->assertRedirect($url);

        $entity = $this->Translations->get($id);
        $this->assertEquals($data['translation'], $entity->get('translation'));
    }

    public function testEditGet(): void
    {
        $this->get('/language-translations/translations/edit/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    public function testDelete(): void
    {
        $this->post('/language-translations/translations/delete/00000000-0000-0000-0000-000000000001', []);
        $this->assertRedirect(['controller' => 'Translations', 'action' => 'index']);
    }
}
