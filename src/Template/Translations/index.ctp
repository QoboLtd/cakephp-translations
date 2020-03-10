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

echo $this->Html->css('Translations./plugins/datatables/css/dataTables.bootstrap.min', ['block' => 'css']);

echo $this->Html->script(
    [
        'Translations./plugins/datatables/datatables.min',
        'Translations./plugins/datatables/js/dataTables.bootstrap.min',
    ],
    ['block' => 'scriptBottom']
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
    <h1>Translations</h1>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __d('Qobo/Translations', 'Model') ?></th>
                        <th><?= __d('Qobo/Translations', 'Field'); ?></th>
                        <th><?= __d('Qobo/Translations', 'Language') ?></th>
                        <th><?= __d('Qobo/Translations', 'Translation'); ?></th>
                        <th class="actions"><?= __d('Qobo/Translations', 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($translations as $translate) : ?>
                    <tr>
                        <td>
                            <?= h($translate->object_model) ?>
                        </td>
                        <td>
                            <?= h($translate->object_field) ?>
                        </td>
                        <td>
                            <?= h($translate->language->name ?: $translate->language->code); ?>
                        </td>
                        <td>
                            <?= h($translate->translation) ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'view', $translate->id],
                                ['title' => __d('Qobo/Translations', 'View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                            ); ?>
                            <?php if (!$translate->deny_edit) : ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'edit', $translate->id],
                                    ['title' => __d('Qobo/Translations', 'Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                                ); ?>
                            <?php endif; ?>
                            <?php if (!$translate->deny_delete) : ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'delete', $translate->id],
                                    [
                                        'confirm' => __d('Qobo/Translations', 'Are you sure you want to delete # {0}?', $translate->id),
                                        'title' => __d('Qobo/Translations', 'Delete'),
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
