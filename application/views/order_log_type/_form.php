<?= render_form_input('description',true);?>
<?= render_select_add_options('field_name',render_options_by_array(_v('fields')));?>
<?= render_select_with_options('field_valuelist_id','vl_valuelist',false,null,false,null,null,null,true)?>
<?= render_select_with_options('dll_type','vl_dll_type');?>
<dl class="row dl-horizontal"><dt><?= render_label('select_field')?></dt>
    <dd>
        <a href="#" onclick="_insertField('&order_id')"><?= label('order_id')?></a>&nbsp;|&nbsp;
        <a href="#" onclick="_insertField('&new_value')"><?= label('new_value')?></a>&nbsp;|&nbsp;
        <a href="#" onclick="_insertField('&old_value')"><?= label('old_value')?></a>&nbsp;|&nbsp;
        <a href="#" onclick="_insertField('&reason')"><?= label('reason')?></a>
    </dd>
</dl>
<?= render_form_input('title',true);?>
<?= render_form_textarea('content',true);?>
<?= render_single_checkbox('need_reason_flag',1)?>
<br/><br/>
<script type="text/javascript">
    var currentFocus = null;
    onWsoLoad(function () {
        var title = dijitObject('title');
        var content = dijitObject('content');
        dojo.connect(title,'onFocus',function(){
            currentFocus = title;
        });
        dojo.connect(content,'onFocus',function(){
            currentFocus = content;
        });
    });
    _insertField = function(str){
        if(currentFocus){
            currentFocus.set('value',currentFocus.value + str);
        }
    }
</script>