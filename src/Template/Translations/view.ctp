<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Translation'), ['action' => 'edit', $translation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Translation'), ['action' => 'delete', $translation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Translations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Translation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Phinxlog'), ['controller' => 'Phinxlog', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Phinxlog'), ['controller' => 'Phinxlog', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="translations view large-9 medium-8 columns content">
    <h3><?= h($translation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($translation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Language') ?></th>
            <td><?= $translation->has('language') ? $this->Html->link($translation->language->name, ['controller' => 'Languages', 'action' => 'view', $translation->language->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Object Foreign Key') ?></th>
            <td><?= h($translation->object_foreign_key) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Object Model') ?></th>
            <td><?= h($translation->object_model) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Object Field') ?></th>
            <td><?= h($translation->object_field) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($translation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($translation->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Translation') ?></h4>
        <?= $this->Text->autoParagraph(h($translation->translation)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Phinxlog') ?></h4>
        <?php if (!empty($translation->phinxlog)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Version') ?></th>
                <th scope="col"><?= __('Migration Name') ?></th>
                <th scope="col"><?= __('Start Time') ?></th>
                <th scope="col"><?= __('End Time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($translation->phinxlog as $phinxlog): ?>
            <tr>
                <td><?= h($phinxlog->version) ?></td>
                <td><?= h($phinxlog->migration_name) ?></td>
                <td><?= h($phinxlog->start_time) ?></td>
                <td><?= h($phinxlog->end_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Phinxlog', 'action' => 'view', $phinxlog->version]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Phinxlog', 'action' => 'edit', $phinxlog->version]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Phinxlog', 'action' => 'delete', $phinxlog->version], ['confirm' => __('Are you sure you want to delete # {0}?', $phinxlog->version)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
