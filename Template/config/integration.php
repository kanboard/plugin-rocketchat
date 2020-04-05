<h3>RocketChat</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL'), 'rocketchat_webhook_url') ?>
    <?= $this->form->text('rocketchat_webhook_url', $values) ?>

    <p class="form-help"><a href="https://github.com/kanboard/plugin-rocketchat#configuration" target="_blank"><?= t('Help on RocketChat integration') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
