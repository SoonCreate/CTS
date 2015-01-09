<?= render_form_header('job_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('job','edit') ?>
    <?php $this->load->view('job/_form');?>
    <?= render_form_hidden('id')?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
