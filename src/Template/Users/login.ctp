<?= $this->Form->create() ?>
<fieldset>
    <legend><?= __('Please enter your username and password') ?></legend>
    <?= $this->Form->control('username') ?>
    <?= $this->Form->control('password') ?>
</fieldset>
<div class="text-center">
<?= $this->Form->button(__('Login')); ?>
</div>
<?= $this->Form->end() ?>