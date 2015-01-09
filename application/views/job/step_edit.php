<?= render_form_header('step_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('job','step_edit') ?>
    <?php $this->load->view('job/_step_form');?>
    <?= render_form_hidden('id')?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
