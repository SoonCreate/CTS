<?= render_form_input('description',TRUE);?>
<?= render_single_checkbox('object_flag',1,label('from_table'),false,null,array('onChange'=>'_onObjectFlagChecked()'))?>
<?= render_select_add_options('source_view',render_options('vl_tables',null,false,true));?>
<?= render_form_input('label_fieldname');?>
<?= render_form_input('value_fieldname');?>
<?= render_form_textarea('condition')?>
<?= render_select_add_options('parent_id',render_options('vl_valuelist',null,false,true));?>

<script type="text/javascript">
    onWsoLoad(function () {
        _onObjectFlagChecked();
    });
    _onObjectFlagChecked = function(){
        var obj = dijitObject('object_flag');
        var sourceView = dijitObject('source_view');
        var labelFieldName = dijitObject('label_fieldname');
        var valueFieldName = dijitObject('value_fieldname');
        var condition = dijitObject('condition');
        if(obj.getValue() == 1){
            sourceView.set('disabled',false);
            labelFieldName.set('disabled',false);
            valueFieldName.set('disabled',false);
            condition.set('disabled',false);
        }else{
            sourceView.set('disabled',"disabled");
            labelFieldName.set('disabled',"disabled");
            valueFieldName.set('disabled',"disabled");
            condition.set('disabled',"disabled");
        }
    }
</script>