<?= render_form_header('form_field_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('form','field_edit','null','null',"_backToEdit") ?>
    <?= render_form_input('field_name',true,true)?>
    <?= render_form_input('label',true)?>
    <?= render_select_with_options('field_type','vl_field_types',true,null,true)?>
    <?= render_form_input('field_size')?>
    <?= render_form_textArea('help_text') ?>
    <?= render_single_checkbox('required_flag',1) ?>
    <?= render_single_checkbox('disabled_flag',1) ?>
    <?= render_single_checkbox('hidden_flag',1) ?>
    <?= render_form_input('default_value') ?>
    <?= render_select_with_options('control','vl_control') ?>
    <?= render_select_with_options('valuelist_id','vl_valuelist',null,null,null,null,null,null,true) ?>
    <?= render_form_input('valuelist_field') ?>
    <?= render_form_input('validation_id') ?>
    <?= render_single_checkbox('inactive_flag',1) ?>
    <?= render_form_hidden('id') ?>
    <?= render_form_hidden('form_id') ?>
    <?= render_submit_button()?>
    <?= render_form_close() ?>
</div>
<script type="text/javascript">
    _backToEdit = function(o){
        $dijit.byId("fmWorkSpace").set("href", url("form/edit?id="+ o.form_id));
    }
</script>