<?= render_form_input('description',TRUE);?>
<dl class="row dl-horizontal">
    <dt><label for="object_flag">来自表/视图</label></dt>
    <dd><input name="object_flag" id="object_flag"  data-dojo-type="sckj/form/CheckBox" type="checkbox" value="1" <?php
        if(_v('object_flag')) : echo 'checked' ;endif;
        ?>/></dd>
</dl>

<?= render_form_input('label_fieldname');?>
<?= render_form_input('value_fieldname');?>


<dl class="row dl-horizontal">
    <dt><label for="source_view">源表/视图</label></dt>
    <dd><select id="source_view" name="source_view" data-dojo-type="sckj/form/Select" >
<?= render_options_with_value('vl_tables',_v('source_view'))?>
</select></dd>
<dl>

<?= render_form_textarea('condition')?>

<?= render_select_with_options('parent_id','vl_valuelist');?>