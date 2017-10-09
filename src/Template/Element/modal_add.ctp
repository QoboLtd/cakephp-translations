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

$modalBody = (!empty($modalBody) ? $modalBody : '');
?>
<div id="translations_translate_id_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title"><?= __('Manage Translations') ?></h2>
            </div> <!-- modal-header -->
            <div class="modal-body">
                <?= $modalBody ?>
            </div>
        </div> <!-- modal-content -->
    </div> <!-- modal-dialog -->
</div> <!-- modal window -->
