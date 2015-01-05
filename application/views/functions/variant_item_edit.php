<?= render_form_header('variant_item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('functions','variant_item_edit') ?>
    <?php $this->load->view('functions/_variant_item_form');?>
    <?= render_form_hidden('id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
