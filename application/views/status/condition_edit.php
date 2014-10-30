<?= render_form_header('condition_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('status','condition_edit') ?>
    <?php $this->load->view('status/_condition_form') ?>
    <?= render_form_hidden('id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
