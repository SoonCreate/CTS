<?= render_form_input('description',true);?>
<?= render_select_add_options('field_name',render_options_by_array(_v('fields')));?>
<?= render_select_add_options('field_valuelist_id',render_options('vl_valuelist',null,FALSE,true));?>
<?= render_select_with_options('dll_type','vl_dll_type');?>
    <div>
        可用的显示字段为：&order_id ; &new_value ; &old_value ; &reason
    </div>
<?= render_form_input('title',true);?>
<?= render_form_textarea('content',true);?>
<?= render_form_header('notice_condition');?>
<?= render_single_checkbox('notice_flag',1,'是否需要同时创建通知')?>
<?= render_single_checkbox('notice_created_by',1,'通知到创建者')?>
<?= render_single_checkbox('notice_manager',1,'通知到责任人')?>
<?= render_form_input('when_new_value');?>
<?= render_form_input('when_old_value');?>
<?= render_select_add_options('default_role_id',render_options('vl_roles',null,FALSE,true))?>
<?= render_single_checkbox('need_reason_flag',1,'是否需要填写原因')?>
<br/><br/>