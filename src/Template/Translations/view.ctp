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
<section class="content-header">
    <h1><?= $this->Html->link(
        __('Translations'),
        ['plugin' => 'Translations', 'controller' => 'Translations', 'action' => 'index']
    ) . ' &raquo; ' . h($translation->id) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-globe"></i>

                    <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?= __('Model') ?></dt>
                        <dd><?= h($translation->object_model) ?></dd>
                        <dt><?= __('Field') ?></dt>
                        <dd><?= h($translation->object_field) ?></dd>
                        <dt><?= __('Language') ?></dt>
                        <dd><?= h($translation->language->name ?: $translation->language->code); ?></dd>
                        <dt><?= __('Translation') ?></dt>
                        <dd><?= h($translation->translation) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>

