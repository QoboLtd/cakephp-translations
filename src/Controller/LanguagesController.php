<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Translations\Controller;


/**
 * Languages Controller
 *
 * @property \Translations\Model\Table\LanguagesTable $Languages
 */
class LanguagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $languages = $this->Languages->find('all');
        $this->set(compact('languages'));
        $this->set('_serialize', ['languages']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $language = $this->Languages->newEntity();
        if ($this->request->is('post')) {
            $data = is_array($this->request->getData()) ? $this->request->getData() : [];
            $languageEntity = $this->Languages->addOrRestore($data);
            if (!empty($languageEntity)) {
                $this->Flash->success((string)__d('Qobo/Translations', 'The language has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__d('Qobo/Translations', 'The language could not be saved. Please, try again.'));
        }
        $languages = $this->Languages->getAvailable();
        $this->set(compact('language', 'languages'));
        $this->set('_serialize', ['language']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|void|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $language = $this->Languages->get($id);
        if ($this->Languages->delete($language)) {
            $this->Flash->success((string)__d('Qobo/Translations', 'The language has been deleted.'));
        } else {
            $this->Flash->error((string)__d('Qobo/Translations', 'The language could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
