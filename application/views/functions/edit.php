<?= render_form_header('function_edit');?>
<?= render_form_open('functions','edit') ?>
<div class="container-fluid userd">
    <?= render_form_input('function_name',null,array(),true);?>
    <?= render_form_input('controller',true);?>
    <?= render_form_input('action',true);?>
    <?= render_form_input('description',true);?>
    <?= render_single_checkbox('display_flag',1);?>
    <?= render_form_input('display_class');?>
    <?= render_form_textarea('help');?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>