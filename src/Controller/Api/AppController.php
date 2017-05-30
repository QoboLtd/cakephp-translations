<?php
namespace Translations\Controller\Api;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Crud\Controller\ControllerTrait;
use ReflectionMethod;

class AppController extends Controller
{
    use ControllerTrait;

    public $components = [
        'RequestHandler',
        'Crud.Crud' => [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
                'Crud.Lookup'
            ],
            'listeners' => [
                'Crud.Api',
                'Crud.ApiPagination',
                'Crud.ApiQueryLog'
            ]
        ]
    ];

    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 100,
    ];

    /**
     * Authentication config
     *
     * @var array
     */
    protected $_authConfig = [
        // non-persistent storage, for stateless authentication
        'storage' => 'Memory',
        'authenticate' => [
            // used for validating user credentials before the token is generated
            'Form' => [
                'scope' => ['Users.active' => 1]
            ],
            // used for token validation
            'ADmad/JwtAuth.Jwt' => [
                'parameter' => 'token',
                'userModel' => 'Users',
                'scope' => ['Users.active' => 1],
                'fields' => [
                    'username' => 'id'
                ],
                'queryDatasource' => true
            ]
        ],
        'unauthorizedRedirect' => false,
        'checkAuthIn' => 'Controller.initialize'
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();

        $this->_authentication();

        $this->_acl();
    }

    /**
     * Method that sets up API Authentication.
     *
     * @link http://www.bravo-kernel.com/2015/04/how-to-add-jwt-authentication-to-a-cakephp-3-rest-api/
     * @return void
     */
    protected function _authentication()
    {
        $this->loadComponent('Auth', $this->_authConfig);

        // set auth user from token
        $user = $this->Auth->getAuthenticate('ADmad/JwtAuth.Jwt')->getUser($this->request);
        $this->Auth->setUser($user);

        // If API authentication is disabled, allow access to all actions. This is useful when using some
        // other kind of access control check.
        // @todo currently, even if API authentication is disabled, we are always generating an API token
        // within the Application for internal system use. That way we populate the Auth->user() information
        // which allows other access control systems to work as expected. This logic can be removed if API
        // authentication is always forced.
        if (!Configure::read('Translations.api.auth')) {
            $this->Auth->allow();
        }
    }

    /**
     * Method that handles ACL checks from third party libraries,
     * if the associated parameters are set in the plugin's configuration.
     *
     * @return void
     * @todo currently only copes with Table class instances. Probably there is better way to handle this.
     */
    protected function _acl()
    {
        $className = Configure::read('Translations.acl.class');
        $methodName = Configure::read('Translations.acl.method');
        $componentName = Configure::read('Translations.acl.component');

        if ($componentName) {
            $this->loadComponent($componentName, [
                'currentRequest' => $this->request->params
            ]);
        }

        if (!$className || !$methodName) {
            return;
        }

        $class = TableRegistry::get($className);

        if (!method_exists($class, $methodName)) {
            return;
        }

        $method = new ReflectionMethod($class, $methodName);

        if (!$method->isPublic()) {
            return;
        }

        if ($method->isStatic()) {
            $class::{$methodName}($this->request->params, $this->Auth->user());
        } else {
            $class->{$methodName}($this->request->params, $this->Auth->user());
        }
    }

    /**
     * View CRUD action events handling logic.
     *
     * @return \Cake\Network\Response
     */
    public function view()
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            $ev = new Event('Translations.View.beforeFind', $this, [
                'query' => $event->subject()->query
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('afterFind', function (Event $event) {
            $ev = new Event('Translations.View.afterFind', $this, [
                'entity' => $event->subject()->entity
            ]);
            $this->eventManager()->dispatch($ev);
        });

        return $this->Crud->execute();
    }

    /**
     * Index CRUD action events handling logic.
     *
     * @return \Cake\Network\Response
     */
    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $event) {
            $ev = new Event('Translations.Index.beforePaginate', $this, [
                'query' => $event->subject()->query
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('afterPaginate', function (Event $event) {
            $ev = new Event('Translations.Index.afterPaginate', $this, [
                'entities' => $event->subject()->entities
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('beforeRender', function (Event $event) {
            $ev = new Event('Translations.Index.beforeRender', $this, [
                'entities' => $event->subject()->entities
            ]);
            $this->eventManager()->dispatch($ev);
        });

        return $this->Crud->execute();
    }

    /**
     * Add CRUD action events handling logic.
     *
     * @return \Cake\Network\Response
     */
    public function add()
    {
        $this->Crud->on('beforeSave', function (Event $event) {
            $ev = new Event('Translations.Add.beforeSave', $this, [
                'entity' => $event->subject()->entity
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('afterSave', function (Event $event) {
            // handle file uploads if found in the request data
            $linked = $this->_fileUploadsUtils->linkFilesToEntity($event->subject()->entity, $this->{$this->name}, $this->request->data);

            $ev = new Event('Translations.Add.afterSave', $this, [
                'entity' => $event->subject()->entity
            ]);
            $this->eventManager()->dispatch($ev);
        });

        return $this->Crud->execute();
    }

    /**
     * Edit CRUD action events handling logic.
     *
     * @return \Cake\Network\Response
     */
    public function edit()
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            $ev = new Event('Translations.Edit.beforeFind', $this, [
                'query' => $event->subject()->query
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('afterFind', function (Event $event) {
            $ev = new Event('Translations.Edit.afterFind', $this, [
                'entity' => $event->subject()->entity
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('beforeSave', function (Event $event) {
            $ev = new Event('Translations.Edit.beforeSave', $this, [
                'entity' => $event->subject()->entity
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('afterSave', function (Event $event) {
            // handle file uploads if found in the request data
            $linked = $this->_fileUploadsUtils->linkFilesToEntity($event->subject()->entity, $this->{$this->name}, $this->request->data);
        });

        return $this->Crud->execute();
    }

    /**
     * Delete CRUD action events handling logic.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        return $this->Crud->execute();
    }

   
    /**
     * Lookup CRUD action events handling logic.
     *
     * @return \Cake\Network\Response
     */
    public function lookup()
    {
        $this->Crud->on('beforeLookup', function (Event $event) {
            $ev = new Event('Translations.beforeLookup', $this, [
                'query' => $event->subject()->query
            ]);
            $this->eventManager()->dispatch($ev);
        });

        $this->Crud->on('afterLookup', function (Event $event) {
            $ev = new Event('Translations.afterLookup', $this, [
                'entities' => $event->subject()->entities
            ]);
            $this->eventManager()->dispatch($ev);
            $event->subject()->entities = $ev->result;
        });

        return $this->Crud->execute();
    }

    /**
     * Before filter handler.
     *
     * @param  \Cake\Event\Event $event The event.
     * @return mixed
     * @link   http://book.cakephp.org/3.0/en/controllers/request-response.html#setting-cross-origin-request-headers-cors
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->response->cors($this->request)
            ->allowOrigin(['*'])
            ->allowMethods(['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'])
            ->allowHeaders(['X-CSRF-Token', 'Origin', 'X-Requested-With', 'Content-Type', 'Accept'])
            ->maxAge($this->_getSessionTimeout())
            ->build();

        // if request method is OPTIONS just return the response with appropriate headers.
        if ('OPTIONS' === $this->request->method()) {
            return $this->response;
        }
    }

    /**
     * Get session timeout in seconds
     *
     * @return int Session lifetime in seconds
     */
    protected function _getSessionTimeout()
    {
        // Read from Session.timeout configuration
        $result = Configure::read('Session.timeout');
        if ($result) {
            $result = $result * 60; // Convert minutes to seconds
        }

        // Read from PHP configuration
        if (!$result) {
            $result = ini_get('session.gc_maxlifetime');
        }

        // Fallback on default
        if (!$result) {
            $result = 1800; // 30 minutes
        }

        return $result;
    }

    /**
     * Generates Swagger annotations
     *
     * Instantiates CsvAnnotation with required parameters
     * and returns its generated swagger annotation content.
     *
     * @param string $path File path
     * @return string
     */
    public static function generateSwaggerAnnotations($path)
    {
        $csvAnnotation = new Annotation(get_called_class(), $path);

        return $csvAnnotation->getContent();
    }
}
