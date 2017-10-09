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

echo $this->Html->css(
    [
        'AdminLTE./plugins/select2/select2.min',
        'Qobo/Utils.select2-bootstrap.min',
        'Qobo/Utils.select2-style'
    ],
    [
        'block' => 'css'
    ]
);
echo $this->Html->script(
    [
        'AdminLTE./plugins/select2/select2.full.min',
        'Qobo/Utils.select2.init'
    ],
    [
        'block' => 'scriptBottom'
    ]
);
?>
<section class="content-header">
    <h1><?= __('Create {0}', ['Language']) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <?= $this->Form->create($language) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <?= $this->Form->input('code', [
                                    'options' => $languages,
                                    'type' => 'select',
                                    'class' => 'select2',
                                    'empty' => false,
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                    &nbsp;
                    <?= $this->Form->button(__('Cancel'), ['class' => 'btn remove-client-validation', 'name' => 'btn_operation', 'value' => 'cancel']); ?>
                </div>
                <?= $this->Form->end() ?>
        </div>
    </div>
</section>
