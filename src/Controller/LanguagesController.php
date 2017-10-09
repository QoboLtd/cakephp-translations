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

use Translations\Controller\AppController;

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
     * @return void
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
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $language = $this->Languages->newEntity();
        if ($this->request->is('post')) {
            $languageEntity = $this->Languages->addOrRestore($this->request->getData());
            if (!empty($languageEntity)) {
                $this->Flash->success(__('The language has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The language could not be saved. Please, try again.'));
        }
        $languages = $this->Languages->getAvailable();
        $this->set(compact('language', 'languages'));
        $this->set('_serialize', ['language']);
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
}
