<section class="content-header">
    <h1><?= __('Edit {0}', ['Translation']) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <?= $this->Form->create($translation) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <dl class="dl">
                                <dt><?= __('Model') ?></dt>
                                <dd><?= h($translation->object_model) ?></dd>
                                <dt><?= __('Field') ?></dt>
                                <dd><?= h($translation->object_field) ?></dd>
                                <dt><?= __('Language') ?></dt>
                                <dd><?= h($translation->language->name ?: $translation->language->code); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-8">
                            <?= $this->Form->input('translation'); ?>
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
    </div>
</section>
