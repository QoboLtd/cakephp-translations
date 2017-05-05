<?php
namespace Translations\Controller;

use Translations\Controller\AppController;
use Translations\Controller\Component\LanguageComponent;

/**
 * Languages Controller
 *
 * @property \Translations\Model\Table\LanguagesTable $Languages
 */
class LanguagesController extends AppController
{
    /**
     *  initialize method
     *
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Translations.Language');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $languages = $this->paginate($this->Languages);
        $langs = $this->Language->languages;
        $this->set(compact('languages', 'langs'));
        $this->set('_serialize', ['languages']);
    }

    /**
     * View method
     *
     * @param string|null $id Language id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $language = $this->Languages->get($id, [
            'contain' => ['Translations']
        ]);

        $this->set('langs', $this->Language->languages);
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
            $data['is_rtl'] = $this->_setDirection($data);
            $data['name'] = $this->Language->languages[$data['code']];

            $language = $this->Languages->patchEntity($language, $data);
            if ($this->Languages->save($language)) {
                $this->Flash->success(__('The language has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The language could not be saved. Please, try again.'));
        }
        $languages = $this->Language->languages;
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
     *  _setDirection method
     *
     * @param array $data   post data
     * @return bool         true in case of right to left language
     */
    protected function _setDirection($data)
    {
        $locale = $data['code'];
        $locale = preg_replace('/_[A-Za-z]+/', '', $locale);

        return in_array($locale, $this->Language->rtl_languages) ? true : false;
    }
}
