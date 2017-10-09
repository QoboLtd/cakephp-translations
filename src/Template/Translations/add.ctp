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
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?= $this->Form->input('orig_for_translate', ['type' => 'textarea', 'label' => 'English', 'id' => 'orig_for_translate', 'required' => false, 'disabled' => true]); ?>
        </div>
    </div>
    <hr/>
    <?php foreach ($languages as $language) : ?>
    <div class="row">
        <?php
            echo $this->Form->create($translation, ['id' => 'form_translation_' . $language->code]);
            echo $this->Form->hidden('object_model');
            echo $this->Form->hidden('object_field');
            echo $this->Form->hidden('object_foreign_key');
            echo $this->Form->hidden('id', ['id' => 'translation_id_' . $language->code]);
            echo $this->Form->hidden('language_id', ['value' => $language->id]);
            echo $this->Form->hidden('code', ['value' => $language->code]);
        ?>
        <div class="col-xs-12 col-md-12">
            <?= $this->Form->input('translation', ['label' => $language->name, 'placeholder' => 'Translation', 'id' => 'translation_' . $language->code, 'required' => false]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="result_<?= $language->code; ?>"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <?= $this->Form->button(__('Save'), ['id' => 'btn_translate_ru', 'name' => 'btn_translation', 'data-lang' => $language->code, 'value' => 'save', 'class' => 'btn btn-primary', 'type' => 'button']); ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
    <br/>
    <?php endforeach; ?>
</section>
