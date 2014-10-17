<?= render_form_input('description',true);?>
<?= render_select_add_options('field_name',render_options_by_array(_v('fields')));?>
<?= render_select_add_options('field_valuelist_id',render_options('vl_valuelist',null,FALSE,true));?>
<?= render_select_with_options('dll_type','vl_dll_type');?>
    <div>
        可用的显示字段为：&order_id ; &new_value ; &old_value ; &reason
    </div>
<?= render_form_input('title',true);?>
<?= render_form_textarea('content',true);?>
<?= render_single_checkbox('need_reason_flag',1,'是否需要填写原因')?>
<br/><br/>