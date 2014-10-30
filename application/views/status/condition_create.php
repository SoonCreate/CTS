<?= render_form_header('condition_create');?>
<div class="container-fluid userd">
    <?= render_form_open('status','condition_create') ?>
    <?php $this->load->view('status/_condition_form') ?>
    <?= render_form_hidden('line_id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
