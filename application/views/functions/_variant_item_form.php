<?= render_form_input('segment_name',true) ?>
<?= render_form_input('segment_value') ?>
<?= render_select_with_options('data_type','vl_data_type',true,null,false,array('onChange'=>'_changeNowFlagDisabledState()'))?>
<?= render_single_checkbox('now_flag',1,null,false,array('onChange'=>'_changeSegmentValueDisabledState(this)'))?>
<script type="text/javascript">
    onWsoLoad(function () {
        _changeNowFlagDisabledState();
    });

    _changeNowFlagDisabledState = function(){
        var dataType = dijitObject('data_type');
        var nowFlag = dijitObject('now_flag');
        if(dataType != undefined && nowFlag != undefined){
            var value = dataType.getValue();
            if(value.indexOf('date') >= 0 || value.indexOf('time') >= 0){
                _changeSegmentValueDisabledState(nowFlag);
                nowFlag.set("disabled",false);
            }else{
                nowFlag.setValue(0);
                nowFlag.set("disabled","disabled");
                _setSegmentValueDisabledFalse();
            }
        }
    };

    _changeSegmentValueDisabledState = function (object) {
        var segmentValue = dijitObject('segment_value');
        if(segmentValue != undefined && object.checked){
            segmentValue.setValue("");
            segmentValue.set("disabled","disabled");
        }else{
            _setSegmentValueDisabledFalse();
        }
    };

    _setSegmentValueDisabledFalse = function(){
        var segmentValue = dijitObject('segment_value');
        if(segmentValue != undefined){
            segmentValue.set("disabled",false);
        }
    }
</script>
