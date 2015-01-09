<?= render_form_header('step_create');?>
<div class="container-fluid userd">
    <?= render_form_open('job','step_create') ?>
    <?php $this->load->view('job/_step_form');?>
    <?= render_form_hidden('job_id')?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
