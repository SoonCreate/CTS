<?= render_form_header('variant_item_create');?>
<div class="container-fluid userd">
    <?= render_form_open('functions','variant_item_create') ?>
    <?php $this->load->view('functions/_variant_item_form');?>
    <?= render_form_hidden('variant_id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
