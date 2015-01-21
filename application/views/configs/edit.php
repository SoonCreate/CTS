<?= render_form_header('config_edit')?>
<div class="container-fluid userd">
    <?= render_form_open('configs','edit') ?>
    <?= render_form_input('config_name',false,TRUE);?>
    <?= render_form_textarea('description',false,TRUE);?>
    <?php if(_v('data_type') == 'boolean'){
        echo render_select_with_options('config_value','ao_true_or_false');
    }else{
        echo render_form_input('config_value',true);
    }?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>