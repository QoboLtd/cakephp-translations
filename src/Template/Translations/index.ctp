<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Translation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Phinxlog'), ['controller' => 'Phinxlog', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Phinxlog'), ['controller' => 'Phinxlog', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="translations index large-9 medium-8 columns content">
    <h3><?= __('Translations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('object_foreign_key') ?></th>
                <th scope="col"><?= $this->Paginator->sort('object_model') ?></th>
                <th scope="col"><?= $this->Paginator->sort('object_field') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($translations as $translation) : ?>
            <tr>
                <td><?= h($translation->id) ?></td>
                <td><?= $translation->has('language') ? $this->Html->link($translation->language->name, ['controller' => 'Languages', 'action' => 'view', $translation->language->id]) : '' ?></td>
                <td><?= h($translation->object_foreign_key) ?></td>
                <td><?= h($translation->object_model) ?></td>
                <td><?= h($translation->object_field) ?></td>
                <td><?= h($translation->created) ?></td>
                <td><?= h($translation->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $translation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $translation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $translation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
