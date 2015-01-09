<?= render_form_input('step',true)?>
<?= render_select_add_options('function_id',render_options('vl_functions',null,false,true),true,array('onChange'=>'_onFunctionSelectChange'))?>
<?= render_select_add_options('variant_id','')?>
<script type="text/javascript">
    onWsoLoad(function () {
        _onFunctionSelectChange();
    });
    _onFunctionSelectChange = function(){
        var o = dijitObject('function_id');
        var v = dijitObject('variant_id');
        if(o != undefined){
            $ajax.get(url("functions/variant_options",{id : o.getValue(),bg: 1}),{handleAs: "json"}).then(function(data){
                v.set("options",data);
                v.set("value", v.getValue());
            });
        }
    }
</script>