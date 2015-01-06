<?= render_form_header('job_create');?>
<div class="container-fluid userd">
    <?= render_form_open('job','create') ?>
    <?php $this->load->view('job/_form');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
