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
namespace Translations\Event\Controller\Api;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Translations\Event\EventName;

class IndexActionListener implements EventListenerInterface
{
    /**
     * Pretty format identifier
     */
    const FORMAT_PRETTY = 'pretty';

    /**
     * Datatables format identifier
     */
    const FORMAT_DATATABLES = 'datatables';

    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return [
            (string)EventName::API_INDEX_BEFORE_PAGINATE() => 'beforePaginate',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforePaginate(Event $event, Query $query)
    {
        $table = $event->subject()->{$event->subject()->name};
        $request = $event->subject()->request;
        $params = $request->query;

        if (!empty($params['object_model']) && !empty($params['object_foreign_key'])) {
            $conditions = [
                'object_model' => $params['object_model'],
                'object_foreign_key' => $params['object_foreign_key'],
            ];

            if (!empty($params['object_field'])) {
                $conditions['object_field'] = $params['object_field'];
            }

            if (!empty($params['language'])) {
                $table = TableRegistry::get('Translations.Translations');
                $conditions['language_id'] = $table->getLanguageId($params['language']);
            }

            $query->applyOptions(['conditions' => $conditions]);
            $query->applyOptions(['contain' => ['Languages']]);
            $query->applyOptions(['fields' =>
                                [
                                    'Translations.translation',
                                    'Translations.object_model',
                                    'Translations.object_foreign_key',
                                    'Translations.object_field',
                                    'Languages.code'
                                ]
            ]);
        } else {
            // In case of missing params to return empty dataset instead of all records
            $query->applyOptions(['conditions' => ['id' => null]]);
        }
    }
}
