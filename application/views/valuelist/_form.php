<?= render_form_input('description',TRUE);?>
<label for="object_flag">来自表/视图</label>
<input name="object_flag" id="object_flag" type="checkbox" value="1"
    <?php if(_v('object_flag')) : echo 'checked'; endif;?>
    /><br/>
<?= render_form_input('label_fieldname');?>
<?= render_form_input('value_fieldname');?>

<label for="source_view">源表/视图</label>
<select id="source_view" name="source_view" data-dojo-type="sckj/form/Select" >
<?= render_options_with_value('vl_tables',_v('source_view'))?>
</select>
<br/>

<label for="condition">查询条件</label>
<textarea name="condition" id="condition" type="text"><?= _v('condition')?></textarea><br/>

<label for="parent_id">父值集</label>
<select id="parent_id" name="parent_id">
    <option></option>
    <?= render_options_with_value('vl_valuelist',_v('parent_id'));?>
</select>
<br/>