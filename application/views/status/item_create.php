<?= render_form_header('item_create');?>
<div class="container-fluid userd">
    <?= render_form_open('status','item_create') ?>
    <?= render_form_input('step',true) ?>
    <?php $this->load->view('status/_item_form') ?>
    <?= render_form_hidden('status_id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
