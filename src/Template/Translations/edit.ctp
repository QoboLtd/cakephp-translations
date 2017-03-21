<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $translation->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $translation->id)]
        )
        ?></li>
        <li><?= $this->Html->link(__('List Translations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Phinxlog'), ['controller' => 'Phinxlog', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Phinxlog'), ['controller' => 'Phinxlog', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="translations form large-9 medium-8 columns content">
    <?= $this->Form->create($translation) ?>
    <fieldset>
        <legend><?= __('Edit Translation') ?></legend>
        <?php
            echo $this->Form->control('language_id', ['options' => $languages]);
            echo $this->Form->control('object_foreign_key');
            echo $this->Form->control('object_model');
            echo $this->Form->control('object_field');
            echo $this->Form->control('translation');
            echo $this->Form->control('phinxlog._ids', ['options' => $phinxlog]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
