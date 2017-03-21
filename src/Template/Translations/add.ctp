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
<section class="content-header">
    <h1><?= $this->Html->link(
        __('Translations'),
        ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'index']
    ) . ' &raquo; ' . h($translation->id) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-solid"> 
                <h3><?= __('To add new translation please go to specific record and choose the field!') ?></h3>
            </div>
        </div>
    </div>
</section>   
