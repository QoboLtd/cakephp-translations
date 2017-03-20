<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Language'), ['action' => 'edit', $language->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Language'), ['action' => 'delete', $language->id], ['confirm' => __('Are you sure you want to delete # {0}?', $language->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Languages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Language'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Translations'), ['controller' => 'Translations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Translation'), ['controller' => 'Translations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="languages view large-9 medium-8 columns content">
    <h3><?= h($language->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($language->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($language->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Short Code') ?></th>
            <td><?= h($language->short_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($language->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($language->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($language->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Translations') ?></h4>
        <?php if (!empty($language->translations)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Language Id') ?></th>
                <th scope="col"><?= __('Object Foreign Key') ?></th>
                <th scope="col"><?= __('Object Model') ?></th>
                <th scope="col"><?= __('Object Field') ?></th>
                <th scope="col"><?= __('Translation') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($language->translations as $translations) : ?>
            <tr>
                <td><?= h($translations->id) ?></td>
                <td><?= h($translations->language_id) ?></td>
                <td><?= h($translations->object_foreign_key) ?></td>
                <td><?= h($translations->object_model) ?></td>
                <td><?= h($translations->object_field) ?></td>
                <td><?= h($translations->translation) ?></td>
                <td><?= h($translations->created) ?></td>
                <td><?= h($translations->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Translations', 'action' => 'view', $translations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Translations', 'action' => 'edit', $translations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Translations', 'action' => 'delete', $translations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
