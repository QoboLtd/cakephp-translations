<?php
namespace Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Translations\Controller\TranslationsController Test Case
 *
 * @property \Translations\Model\Table\TranslationsTable $Translations
 */
class TranslationsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public $fixtures = [
        'plugin.Translations.Languages',
        'plugin.Translations.LanguageTranslations',
    ];

    public function setUp()
    {
        parent::setUp();

        /**
         * @var \Translations\Model\Table\TranslationsTable $table
         */
        $table = TableRegistry::getTableLocator()->get('Translations.Translations');
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
        $this->get('/language-translations/translations?json=1&model=Leads&foreign_key=00000000-0000-0000-0000-100000000001');
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
            'foreign_key' => '00000000-0000-0000-0000-100000000001',
            'model' => 'Leads',
            'field' => 'description',
            'content' => 'Russian translation.',
        ];

        $this->post('/language-translations/translations/add', $data);

        $url = [
            'plugin' => 'Translations',
            'controller' => 'Translations',
            'action' => 'index',
        ];
        $this->assertRedirect($url);

        $this->assertEquals($expected, $this->Translations->find('all')->count());
    }

    public function testAddInvalidData(): void
    {
        $expected = $this->Translations->find('all')->count();

        $data = [
            // invalid lanuage id
            'language_id' => '00000000-0000-0000-0000-000000000999',
            'foreign_key' => '00000000-0000-0000-0000-100000000001',
            'model' => 'Leads',
            'field' => 'description',
            'content' => 'Russian translation.',
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
                'X-Requested-With' => 'XMLHttpRequest',
            ],
        ]);

        $data = [
            'model' => 'Leads',
            'field' => 'description',
            'content' => 'Chinese translation.',
            'language_id' => '00000000-0000-0000-0000-000000000003',
            'foreign_key' => '00000000-0000-0000-0000-100000000001',
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
            'content' => 'Modify translation.',
        ];

        $this->put('/language-translations/translations/edit/' . $id, $data);

        $url = [
            'plugin' => 'Translations',
            'controller' => 'Translations',
            'action' => 'index',
        ];
        $this->assertRedirect($url);

        $entity = $this->Translations->get($id);
        $this->assertEquals($data['content'], $entity->get('content'));
    }

    public function testEditFail(): void
    {
        $this->enableRetainFlashMessages();

        // prevent save
        EventManager::instance()->on('Model.beforeSave', function () {
            return false;
        });

        $id = '00000000-0000-0000-0000-000000000001';

        $this->put('/language-translations/translations/edit/' . $id, ['name' => uniqid()]);
        // $this->assertResponseCode(200);

        $this->assertSession('The translation could not be saved. Please, try again.', 'Flash.flash.0.message');

        $this->assertInstanceOf(
            \Translations\Model\Entity\Translation::class,
            $this->Translations->get($id)
        );
    }

    public function testEditGet(): void
    {
        $this->get('/language-translations/translations/edit/00000000-0000-0000-0000-000000000001');
        $this->assertResponseOk();
    }

    public function testDelete(): void
    {
        $this->delete('/language-translations/translations/delete/00000000-0000-0000-0000-000000000001');
        $this->assertRedirect(['controller' => 'Translations', 'action' => 'index']);
    }

    public function testDeleteFail(): void
    {
        $this->enableRetainFlashMessages();

        // prevent delete
        EventManager::instance()->on('Model.beforeDelete', function () {
            return false;
        });

        $id = '00000000-0000-0000-0000-000000000001';

        $this->delete('/language-translations/translations/delete/' . $id);
        $this->assertRedirect(['controller' => 'Translations', 'action' => 'index']);

        $this->assertSession('The translation could not be deleted. Please, try again.', 'Flash.flash.0.message');

        $this->assertInstanceOf(
            \Translations\Model\Entity\Translation::class,
            $this->Translations->get($id)
        );
    }
}
