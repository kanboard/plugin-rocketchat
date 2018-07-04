<h3><img src="<?= $this->url->dir() ?>plugins/RocketChat/rocketchat-icon.png"/>&nbsp;RocketChat</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL'), 'rocketchat_webhook_url') ?>
    <?= $this->form->text('rocketchat_webhook_url', $values) ?>

    <?= $this->form->label(t('Channel (Optional)'), 'rocketchat_webhook_channel') ?>
    <?= $this->form->text('rocketchat_webhook_channel', $values, array(), array('placeholder="#channel"')) ?>
    <p class="form-help"><a href="https://github.com/kanboard/plugin-rocketchat#configuration" target="_blank"><?= t('Help on RocketChat integration') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue">
    </div>
</div>
