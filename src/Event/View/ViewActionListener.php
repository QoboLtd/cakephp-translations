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
namespace Translations\Event\View;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Translations\Event\EventName;

class ViewActionListener implements EventListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return [
            (string)EventName::VIEW_BOTTOM() => 'getTranslationsModal',
        ];
    }

    /**
     * getTranslationsModal modal for fields translation
     *
     * @param \Cake\Event\Event $event from the view ctp
     * @param mixed $request from the event broadcasted
     * @param array $options that hold request object and options
     *
     * @return void
     */
    public function getTranslationsModal(Event $event, $request, array $options = [])
    {
        $appView = $event->subject();
        $elementName = 'Translations.modal_add';

        if (!$appView->elementExists($elementName)) {
            return;
        }

        $modalBody = $appView->requestAction([
            'plugin' => 'Translations',
            'controller' => 'Translations',
            'action' => 'add'
        ], [
            'query' => [
                'embedded' => 'Translations',
                'foreign_key' => 'object_foreign_key',
                'modal_id' => 'translations_translate_id_modal',
            ]
        ]);

        $content = $appView->element($elementName, ['modalBody' => $modalBody]);

        $event->result .= $content;
    }
}
