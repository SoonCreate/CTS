<?= render_select_with_options('and_or','vl_and_or',true) ?>
<?php //render_select_with_options('table_name','vl_tables',true,array('onChange'=>'_conditionFormFieldSelect(this)')) ?>
<?= render_select_add_options('field_name',render_options_by_array(_v('field_options')),true) ?>
<?= render_select_with_options('operation','vl_operations',true) ?>
<?= render_form_input('target_value',true) ?>
<?= render_form_hidden('group_id');?>
<!--<script type="text/javascript">-->
<!--    function _conditionFormFieldSelect(table){-->
<!--        $ajax.get(url("welcome/field_list?table="+table.getValue()),{handleAs : "json"}).then(function(data){-->
<!--            dijitObject("field_name").set("options",data);-->
<!--        });-->
<!--    }-->
<!--</script>-->