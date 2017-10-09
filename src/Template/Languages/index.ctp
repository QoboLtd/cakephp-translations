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

use Cake\Core\Configure;

echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/datatables/jquery.dataTables.min',
        'AdminLTE./plugins/datatables/dataTables.bootstrap.min'
    ],
    [
        'block' => 'scriptBottom'
    ]
);
echo $this->Html->scriptBlock(
    '$(".table-datatable").DataTable({
        stateSave: true,
        stateDuration: ' . (int)(Configure::read('Session.timeout') * 60) . '
    });',
    ['block' => 'scriptBottom']
);
?>
<section class="content-header">
    <h1>Languages
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
            <?= $this->Html->link(
                '<i class="fa fa-plus"></i> ' . __('Add'),
                ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'add'],
                ['escape' => false, 'title' => __('Add'), 'class' => 'btn btn-default']
            ); ?>
            </div>
        </div>
    </h1>
</section>
<section class="content">
    <div class="box box-solid">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Code') ?></th>
                        <th><?= __('Direction'); ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($languages as $language) : ?>
                    <tr>
                        <td>
                            <?= h($language->name); ?>
                        </td>
                        <td>
                            <?= h($language->code) ?>
                        </td>
                        <td>
                            <?= h($language->is_rtl ? 'Right-to-left' : 'Left-to-right'); ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                            <?php if (!$language->deny_delete) : ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'delete', $language->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $language->id),
                                        'title' => __('Delete'),
                                        'class' => 'btn btn-default btn-sm',
                                        'escape' => false
                                    ]
                                ) ?>
                            <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
