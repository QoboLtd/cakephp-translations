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
 * Translations Controller
 *
 * @property \Translations\Model\Table\TranslationsTable $Translations
 */
class TranslationsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $params = $this->request->getQueryParams();
        $languageId = !empty($params['language']) ? $this->Translations->getLanguageId($params['language']) : null;

        if (!empty($params['json']) && $params['json']) {
            $translations = $this->Translations->getTranslations(
                $params['object_model'],
                $params['object_foreign_key'],
                [
                    'language' => $languageId,
                    'field' => !empty($params['object_field']) ? $params['object_field'] : '',
                ]
            );
            $this->response->type('application/json');
            $this->autoRender = false;
            echo json_encode($translations, JSON_UNESCAPED_UNICODE);
        } else {
            $translations = $this->Translations->find('all')->contain('Languages');
            $this->set(compact('translations'));
            $this->set('_serialize', ['translations']);
        }
    }

    /**
     * View method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @param string|null $id Translation id.
     * @return void
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
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise
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
     * Add or update method
     *
     * @return void     When successfully added or updated prints in JSON true, false otherwise
     */
    public function addOrUpdate()
    {
        $this->request->allowMethod(['post']);
        if (!$this->request->is('ajax')) {
            throw new \RuntimeException('Wrong type of request!');
        }
        $params = $this->request->getData();
        $translation = $this->Translations->getTranslations(
            $params['object_model'],
            $params['object_foreign_key'],
            [
                'language' => $params['language_id'],
                'toEntity' => true,
                'field' => $params['object_field'],
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
