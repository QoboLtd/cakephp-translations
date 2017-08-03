<?php
namespace Translations\Controller;

use Translations\Controller\AppController;

/**
 * Languages Controller
 *
 * @property \Translations\Model\Table\LanguagesTable $Languages
 */
class LanguagesController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $languages = $this->Languages->find('all');
        $langs = $this->Languages->getAll();
        $this->set(compact('languages', 'langs'));
        $this->set('_serialize', ['languages']);
    }

    /**
     * View method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @param string|null $id Language id.
     * @return void
     */
    public function view($id = null)
    {
        $language = $this->Languages->get($id, [
            'contain' => ['Translations']
        ]);

        $this->set('langs', $this->Languages->getAll());
        $this->set('language', $language);
        $this->set('_serialize', ['language']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $language = $this->Languages->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['is_rtl'] = $this->Languages->isRtl($data['code']);
            $data['name'] = $this->Languages->getName([$data['code']]);

            $languageEntity = $this->_loadDeletedLanguage($data['code']);
            if (!empty($languageEntity)) {
                $this->Languages->restoreTrash($languageEntity);

                return $this->redirect(['action' => 'index']);
            }

            $language = $this->Languages->patchEntity($language, $data);
            if ($this->Languages->save($language)) {
                $this->Flash->success(__('The language has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The language could not be saved. Please, try again.'));
        }
        $languages = $this->Languages->getAll();
        $this->set(compact('language', 'languages'));
        $this->set('_serialize', ['language']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Language id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Edit language is disabled because no any property to do that
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Language id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $language = $this->Languages->get($id);
        if ($this->Languages->delete($language)) {
            $this->Flash->success(__('The language has been deleted.'));
        } else {
            $this->Flash->error(__('The language could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     *  _loadDeletedLanguage() method
     *
     * @param string $code  language code
     * @return bool|\Cake\Datasource\EntityInterface
     */
    protected function _loadDeletedLanguage($code)
    {
        $query = $this->Languages->find('onlyTrashed')
                                ->where(['code' => $code]);

        return $query->first();
    }
}
