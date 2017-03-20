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
        $translations = $this->paginate($this->Translations);

        $this->set(compact('translations'));
        $this->set('_serialize', ['translations']);
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
            'contain' => ['Languages', 'Phinxlog']
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
            if ($this->Translations->save($translation)) {
                $this->Flash->success(__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be saved. Please, try again.'));
        }
        $languages = $this->Translations->Languages->find('list', ['limit' => 200]);
        $phinxlog = $this->Translations->Phinxlog->find('list', ['limit' => 200]);
        $this->set(compact('translation', 'languages', 'objects', 'phinxlog'));
        $this->set('_serialize', ['translation']);
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
            'contain' => ['Phinxlog']
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
        $phinxlog = $this->Translations->Phinxlog->find('list', ['limit' => 200]);
        $this->set(compact('translation', 'languages', 'objects', 'phinxlog'));
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
