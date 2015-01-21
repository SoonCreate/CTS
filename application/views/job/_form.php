<?= render_form_input('job_name',true)?>
<?= render_form_input('description',true)?>
<?= render_select_with_options('output_type','vl_output_type',true)?>
<?= render_form_dateTimeBox('first_exec_date',true)?>
<?= render_form_dateTimeBox('inactive_date')?>
<?= render_single_checkbox('period_flag',1,null,false,array('onChange'=>'_onPeriodFlagChecked()'))?>
<?= render_select_with_options('period_type','vl_period_type')?>
<?= render_form_input('period_value')?>

<script type="text/javascript">
    onWsoLoad(function () {
        _onPeriodFlagChecked();
    });
    _onPeriodFlagChecked = function(){
        var obj = dijitObject('period_flag');
        var periodType = dijitObject('period_type');
        var periodValue = dijitObject('period_value');
        if(obj.getValue() == 1){
            periodType.set('disabled',false);
            periodValue.set('disabled',false);
        }else{
            periodType.set('disabled',"disabled");
            periodValue.set('disabled',"disabled");
        }
    }
</script>