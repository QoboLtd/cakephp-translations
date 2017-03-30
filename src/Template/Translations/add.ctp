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
<div class="alert">
    <h4 id="translate_result" ></h4>
</div>

<section class="content">
    <?php foreach ($languages as $language) : ?>
    <div class="row">
        <?php
            echo $this->Form->create($translation);
            echo $this->Form->hidden('object_model');
            echo $this->Form->hidden('object_field');
            echo $this->Form->hidden('object_foreign_key');
            echo $this->Form->hidden('language_id', ['value' => $language->id]);
        ?>        
        <div class="col-xs-12 col-md-6">
            <?= $this->Form->input('translation', ['label' => false, 'placeholder' => 'Translation', 'id' => 'translation_' . $language->short_code]); ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?= $language->name ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?= $this->Form->button(__('Save'), ['id' => 'btn_translate_ru', 'name' => 'btn_translation', 'value' => 'save', 'class' => 'btn btn-primary', 'type' => 'button']); ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
    <?php endforeach; ?>
</section>
