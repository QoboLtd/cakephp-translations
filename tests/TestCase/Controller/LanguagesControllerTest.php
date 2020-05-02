<?php
namespace Translations\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Webmozart\Assert\Assert;

/**
 * Translations\Controller\LanguagesController Test Case
 *
 * @property \Translations\Model\Table\LanguagesTable $Languages
 */
class LanguagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public $fixtures = [
        'plugin.Translations.Languages',
    ];

    public function setUp()
    {
        parent::setUp();

        /**
         * @var \Translations\Model\Table\LanguagesTable $table
         */
        $table = TableRegistry::getTableLocator()->get('Translations.Languages');
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
        Configure::load('Translations.translations');
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
         * @var \Translations\Model\Entity\Language $first
         */
        $first = $query->first();
        $this->assertEquals('Greek (Cyprus)', $first->get('name'));
    }

    public function testAddFail(): void
    {
        $this->disableErrorHandlerMiddleware();

        $this->enableRetainFlashMessages();

        $data = [
            'code' => 'ru', // already exists
        ];
        $this->post('/language-translations/languages/add', $data);
        $this->assertResponseCode(200);

        $this->assertSession('The language could not be saved. Please, try again.', 'Flash.flash.0.message');

        $query = $this->Languages->find()->where($data);
        $this->assertEquals(1, $query->count());
        $language = $query->firstOrFail();
        Assert::isInstanceOf($language, \Translations\Model\Entity\Language::class);
        $this->assertEquals('Russian', $language->get('name'));
    }

    public function testDelete(): void
    {
        $this->delete('/language-translations/languages/delete/00000000-0000-0000-0000-000000000001');
        $this->assertRedirect(['controller' => 'Languages', 'action' => 'index']);
    }

    public function testDeleteFail(): void
    {
        $this->enableRetainFlashMessages();

        // prevent delete
        EventManager::instance()->on('Model.beforeDelete', function () {
            return false;
        });

        $id = '00000000-0000-0000-0000-000000000001';

        $this->delete('/language-translations/languages/delete/' . $id);
        $this->assertRedirect(['controller' => 'Languages', 'action' => 'index']);

        $this->assertSession('The language could not be deleted. Please, try again.', 'Flash.flash.0.message');

        $this->assertInstanceOf(
            \Translations\Model\Entity\Language::class,
            $this->Languages->get($id)
        );
    }
}
