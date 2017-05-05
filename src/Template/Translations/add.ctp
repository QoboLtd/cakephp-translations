<?php
echo $this->Html->css(
    [
        'AdminLTE./plugins/select2/select2.min',
        'Groups.select2-bootstrap.min'
    ],
    [
        'block' => 'css'
    ]
);
echo $this->Html->script('AdminLTE./plugins/select2/select2.full.min', ['block' => 'scriptBotton']);
echo $this->Html->scriptBlock(
    '$(".select2").select2({
        theme: "bootstrap",
        tags: "true",
        placeholder: "Select an option",
        allowClear: true
    });',
    ['block' => 'scriptBotton']
);
?>

<div id="orig_for_translate"></div>

<div id="translate_result">
</div>

<section class="content">
    <?php foreach ($languages as $language) : ?>
    <div class="row">
        <?php
            echo $this->Form->create($translation);
            echo $this->Form->hidden('object_model');
            echo $this->Form->hidden('object_field');
            echo $this->Form->hidden('object_foreign_key');
            echo $this->Form->hidden('id', ['id' => 'translation_id_' . $language->code]);
            echo $this->Form->hidden('language_id', ['value' => $language->id]);
            echo $this->Form->hidden('code', ['value' => $language->code]);
        ?>        
        <div class="col-xs-12 col-md-7">
            <?= $this->Form->input('translation', ['label' => false, 'placeholder' => 'Translation', 'id' => 'translation_' . $language->code]); ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?= $language->name; ?>
        </div>
        <div class="col-xs-12 col-md-2">
            <?= $this->Form->button(__('Save'), ['id' => 'btn_translate_ru', 'name' => 'btn_translation', 'data-lang' => $language->code, 'value' => 'save', 'class' => 'btn btn-primary', 'type' => 'button']); ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="result_<?= $language->code; ?>"></div>
        </div>
    </div>    
    <?php endforeach; ?>
</section>
