<?php
namespace Translations\Controller;

use Translations\Controller\AppController;

/**
 * Translations Controller
 *
 * @property \Translations\Model\Table\TranslationsTable $Translations
 */
class TranslationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Languages']
        ];

        $params = $this->request->getQueryParams();
        $language_id = !empty($params['language']) ? $this->Translations->getLanguageId($params['language']) : null;

        if (!empty($params['json']) && $params['json']) {
            $translations = $this->Translations->getTranslations(
                $params['object_model'], 
                $params['object_foreign_key'], 
                $params['object_field'],
                [
                    'language' => $language_id
                ]    
            );
            $this->response->type('application/json');
            $this->autoRender = false;
            echo json_encode($translations, JSON_UNESCAPED_UNICODE);
        } else {
            $translations = $this->paginate($this->Translations);
            $this->set(compact('translations'));
            $this->set('_serialize', ['translations']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Translation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $translation = $this->Translations->get($id, [
            'contain' => ['Languages']
        ]);

        $this->set('translation', $translation);
        $this->set('_serialize', ['translation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $translation = $this->Translations->newEntity();
        if ($this->request->is('post')) {
            $translation = $this->Translations->patchEntity($translation, $this->request->getData());
            $result = $this->Translations->save($translation);
            if ($result) {
                $this->Flash->success(__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be saved. Please, try again.'));
        }
        $languages = $this->Translations->Languages->find('all', ['limit' => 200]);
        $this->set(compact('translation', 'languages'));
        $this->set('_serialize', ['translation']);
    }

    /**
     *  Add or update method
     *
     *
     */
    public function addOrUpdate()
    {
        $params = $this->request->getData();
        $translation = $this->Translations->getTranslations(
            $params['object_model'],
            $params['object_foreign_key'],
            $params['object_field'],
            [
                'language' => $params['language_id'],
                'toEntity' => true,
            ]    
        ); 
        if (empty($translation)) {
            $translation = $this->Translations->newEntity();
        }

        $translation = $this->Translations->patchEntity($translation, $params);
        $result = $this->Translations->save($translation);

        $this->response->type('application/json');
        $this->autoRender = false;
        echo json_encode(!empty($result) ? true : false);
    }

    /**
     * Edit method
     *
     * @param string|null $id Translation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $translation = $this->Translations->get($id, [
            'contain' => ['Languages']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $translation = $this->Translations->patchEntity($translation, $this->request->getData());
            if ($this->Translations->save($translation)) {
                $this->Flash->success(__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be saved. Please, try again.'));
        }
        $languages = $this->Translations->Languages->find('list', ['limit' => 200]);
        $this->set(compact('translation', 'languages'));
        $this->set('_serialize', ['translation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Translation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $translation = $this->Translations->get($id);
        if ($this->Translations->delete($translation)) {
            $this->Flash->success(__('The translation has been deleted.'));
        } else {
            $this->Flash->error(__('The translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
