<?= render_form_header('config_edit')?>
<div class="container-fluid userd">
    <?= render_form_open('user','config_edit') ?>
    <?= render_form_input('config_name',null,array(),TRUE);?>
    <?= render_form_textarea('description',null,array(),TRUE);?>
    <?php if(_v('data_type') == 'boolean'){
        echo render_select_with_options('config_value','ao_true_or_false');
    }else{
        echo render_form_input('config_value',true);
    }?>
    <?= render_form_hidden('id',_v('config_id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>