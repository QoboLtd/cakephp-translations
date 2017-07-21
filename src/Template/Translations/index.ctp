<?php
use Cake\Core\Configure;

echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/datatables/jquery.dataTables.min',
        'AdminLTE./plugins/datatables/dataTables.bootstrap.min'
    ],
    [
        'block' => 'scriptBotton'
    ]
);
echo $this->Html->scriptBlock(
    '$(".table-datatable").DataTable({
        stateSave: true,
        stateDuration: ' . (int)(Configure::read('Session.timeout') * 60) . '
    });',
    ['block' => 'scriptBotton']
);
?>
<section class="content-header">
    <h1>Translations</h1>
</section>
<section class="content">
    <div class="box box-solid">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= h('Model') ?></th>
                        <th><?= h('Field'); ?></th>
                        <th><?= h('Language') ?></th>
                        <th><?= h('Translation'); ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
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
                            <?= h(!empty($locales[$translate->language->code]) ? $locales[$translate->language->code] : $translate->language->code); ?>
                        </td>
                        <td>
                            <?= h($translate->translation) ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'view', $translate->id],
                                ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                            ); ?>
                            <?php if (!$translate->deny_edit) : ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'edit', $translate->id],
                                    ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                                ); ?>
                            <?php endif; ?>
                            <?php if (!$translate->deny_delete) : ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'delete', $translate->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $translate->id),
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