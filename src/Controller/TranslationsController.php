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
     * @return \Cake\Http\Response|void
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
            $body = (string)json_encode($translations, JSON_UNESCAPED_UNICODE);
            $this->response = $this->response->withType('application/json')->withStringBody($body);
            $this->autoRender = false;
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
     * @return \Cake\Http\Response|void
     */
    public function view(string $id = null)
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
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise
     */
    public function add()
    {
        $translation = $this->Translations->newEntity();
        if ($this->request->is('post')) {
            $data = is_array($this->request->getData()) ? $this->request->getData() : [];
            $translation = $this->Translations->patchEntity($translation, $data);
            $result = $this->Translations->save($translation);
            if ($result) {
                $this->Flash->success((string)__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The translation could not be saved. Please, try again.'));
        }
        $languages = $this->Translations->Languages->find('all', ['limit' => 200]);
        $this->set(compact('translation', 'languages'));
        $this->set('_serialize', ['translation']);
    }

    /**
     * Add or update method
     *
     * @return \Cake\Http\Response|void     When successfully added or updated prints in JSON true, false otherwise
     */
    public function addOrUpdate()
    {
        $this->request->allowMethod(['post']);
        if (!$this->request->is('ajax')) {
            throw new \RuntimeException('Wrong type of request!');
        }
        $params = is_array($this->request->getData()) ? $this->request->getData() : [];
        /**
         * @var \Cake\Datasource\EntityInterface $translation
         */
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
            /**
             * @var \Cake\Datasource\EntityInterface $translation
             */
            $translation = $this->Translations->newEntity();
        }

        $translation = $this->Translations->patchEntity($translation, $params);
        $result = $this->Translations->save($translation);
        $body = (string)json_encode(!empty($result) ? true : false);
        $this->response = $this->response->withType('application/json')->withStringBody($body);
        $this->autoRender = false;
    }

    /**
     * Edit method
     *
     * @param string|null $id Translation id.
     * @return \Cake\Http\Response|void|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(string $id = null)
    {
        $translation = $this->Translations->get($id, [
            'contain' => ['Languages']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = is_array($this->request->getData()) ? $this->request->getData() : [];
            $translation = $this->Translations->patchEntity($translation, $data);
            if ($this->Translations->save($translation)) {
                $this->Flash->success((string)__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The translation could not be saved. Please, try again.'));
        }
        $languages = $this->Translations->Languages->find('list', ['limit' => 200]);
        $this->set(compact('translation', 'languages'));
        $this->set('_serialize', ['translation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Translation id.
     * @return \Cake\Http\Response|void|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $translation = $this->Translations->get($id);
        if ($this->Translations->delete($translation)) {
            $this->Flash->success((string)__('The translation has been deleted.'));
        } else {
            $this->Flash->error((string)__('The translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
