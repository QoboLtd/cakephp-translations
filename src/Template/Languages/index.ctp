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

use Cake\Core\Configure;

echo $this->Html->css('Translations./plugins/datatables/css/dataTables.bootstrap.min', ['block' => 'css']);

echo $this->Html->script(
    [
        'Translations./plugins/datatables/datatables.min',
        'Translations./plugins/datatables/js/dataTables.bootstrap.min',
    ],
    ['block' => 'scriptBottom']
);

echo $this->Html->scriptBlock(
    "$('.table-datatable').DataTable({
        stateSave:true,
        paging:true,
        searching:false,
        sDom:
        '<\"row view-filter\"<\"col-sm-12\"<\"pull-left\"l><\"pull-right\"f><\"clearfix\">>>t<\"row view-pager\"<\"col-sm-12\"<\"text-center\"p>>>',
        oLanguage: {
            oPaginate: {
            sFirst: 'First page', 
            sPrevious:
            '<i aria-hidden=\"true\" class=\"qobrix-icon qobo-angle-left font-size-10\"></i>', 
            sNext:
            '<i aria-hidden=\"true\" class=\"qobrix-icon qobo-angle-right font-size-10\"></i>', 
            sLast: 'Last page', 
            },
        },
        columnDefs: [
            { targets: 'no-sort', orderable: false }
        ],
        fnDrawCallback: function (oSettings) {
            if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
            } else {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
            }
        },  
        createdRow: function (row, data, index, cells) {
            var topRow = $(this).find('>thead>tr,>tr').eq(0);
            $.each($('td', row), function (colIndex) {
                var label = topRow.find('>td,>th').eq(colIndex).html().trim();
                $(this).prepend(
                    '<div class=\"key\">'+ label +'</div>'
                );
            });
        },
      
    });",
    ['block' => 'scriptBottom']
);

?>
<section class="content-header right-top-action-buttons">
    <div class="row no-gutters">
        <div class="col-md-6">
            <h4>Languages</h4>
        </div> 
        <div class="col-md-6">
            <div class="top-action-buttons custom-actions-box">
                <div role="group" class="btn-group btn-group-sm">
                    <div class="btn-group btn-group-sm">
                        <?= $this->Html->link(
                            '<i class="qobrix-icon qobo-plus"></i> ' . __d('Qobo/Translations', 'Add'),
                            ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'add'],
                            ['escape' => false, 'title' => __d('Qobo/Translations', 'Add'), 'class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __d('Qobo/Translations', 'Name') ?></th>
                        <th><?= __d('Qobo/Translations', 'Code') ?></th>
                        <th><?= __d('Qobo/Translations', 'Direction'); ?></th>
                        <th class="actions no-sort"><?= __d('Qobo/Translations', 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($languages as $language) : ?>
                    <tr>
                        <td>
                            <div class="val"><?= h($language->name); ?></div>
                        </td>
                        <td>
                            <div class="val"><?= h($language->code) ?></div>
                        </td>
                        <td>
                            <div class="val"><?= h($language->is_rtl ? 'Right-to-left' : 'Left-to-right'); ?></div>
                        </td>
                        <td class="actions actions_area">
                            <div class="val">
                                <div class="action_area_dropdown">
                                    <?php if (!$language->deny_delete) : ?>
                                        <?= $this->Form->postLink(
                                            '<i aria-hidden="true" class="qobrix-icon qobo-delete"></i>',
                                            ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'delete', $language->id],
                                            [
                                                'confirm' => __d('Qobo/Translations', 'Are you sure you want to delete {0}?', $language->name),
                                                'title' => __d('Qobo/Translations', 'Delete'),
                                                'class' => 'btn btn-default table_actions',
                                                'escape' => false
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
