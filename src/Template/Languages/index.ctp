<?php
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
    '$(".table-datatable").DataTable();',
    ['block' => 'scriptBotton']
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
    <div class="box">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name') ?></th>
                        <th><?= h('Short Code'); ?></th>
                        <th><?= h('Description'); ?></th>
                        <th><?= h('Status'); ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($languages as $language) : ?>
                    <tr>
                        <td>
                            <?= h($language->name) ?>
                        </td>
                        <td>
                            <?= h($language->short_code) ?>
                        </td>
                        <td>
                            <?= h($language->description) ?>
                        </td>
                        <td>
                            <?= h($language->is_active ? 'Active' : 'Disabled') ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'view', $language->id],
                                ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                            ); ?>
                            <?php if (!$language->deny_edit) : ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'edit', $language->id],
                                    ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                                ); ?>
                            <?php endif; ?>
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
