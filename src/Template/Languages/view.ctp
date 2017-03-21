<section class="content-header">
    <h1><?= $this->Html->link(
        __('Languages'),
        ['plugin' => 'Translations', 'controller' => 'Languages', 'action' => 'index']
    ) . ' &raquo; ' . h($language->name) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-language"></i>

                    <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?= __('Name') ?></dt>
                        <dd><?= h($language->name) ?></dd>
                        <dt><?= __('Short code') ?></dt>
                        <dd><?= h($language->short_code) ?></dd>
                        <dt><?= __('Description') ?></dt>
                        <dd><?= h($language->description) ?></dd>
                        <dt><?= __('Status') ?></dt>
                        <dd><?= h($language->is_active ? 'Active' : 'Disabled') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>

