<?= render_form_header('condition_create');?>
<div class="container-fluid userd">
    <?= render_form_open('status_condition','create') ?>
    <?php $this->load->view('status_condition/_form') ?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
