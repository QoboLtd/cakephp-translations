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
                        <dt><?= __('Code') ?></dt>
                        <dd><?= h($language->code) ?></dd>
                        <dt><?= __('Name') ?></dt>
                        <dd><?= h(!empty($langs[$language->code]) ? $langs[$language->code] : $language->code) ?></dd>
                        <dt><?= __('Description') ?></dt>
                        <dd><?= h($language->description) ?></dd>
                        <dt><?= __('Right to left') ?></dt>
                        <dd><?= h($language->is_rtl ? 'Yes' : 'No') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>

