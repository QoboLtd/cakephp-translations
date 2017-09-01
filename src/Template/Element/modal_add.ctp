<?php
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
