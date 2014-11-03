<?= render_form_header('item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('status_condition','object_item_edit') ?>
    <?= render_form_input('auth_value',true)?>
    <?= render_button('s','_selectDialog(\''._v('auth_item_name').'\')')?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
<script type="text/javascript">
    function _selectDialog(name){
        vlGridDialog(name,null,true,true,dijitObject('auth_value'),false);
    }
</script>