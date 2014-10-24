<?= render_form_header('item_create');?>
<div class="container-fluid userd">
    <?= render_form_open('valuelist','item_create') ?>
    <?php $this->load->view('valuelist/_item_form');?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_form_hidden('parent_segment',v('parent_segment'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>