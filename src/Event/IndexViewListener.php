<?php
namespace Translations\Event;

use App\View\AppView;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\ORM\ResultSet;
use Translations\Model\Table\TranslationsTable;

class IndexViewListener implements EventListenerInterface
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
            'Translations.Index.beforePaginate' => 'beforePaginate',
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

        $conditions = [];
        if (!empty($params['object_model']) && !empty($params['object_foreign_key']) && !empty($params['object_field'])) {
            $conditions = [
                'object_model' => $params['object_model'],
                'object_foreign_key' => $params['object_foreign_key'],
                'object_field' => $params['object_field']
            ];

            if (!empty($params['language'])) {
                $table = TableRegistry::get('Translations.Translations');
                $conditions['language_id'] = $table->getLanguageId($params['language']);
            }
            
            $query->applyOptions(['conditions' => $conditions]);
        }
    }
 }
