<?= render_form_header('item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('valuelist','item_edit') ?>
    <?php $this->load->view('valuelist/_item_form');?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>