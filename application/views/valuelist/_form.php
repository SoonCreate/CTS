<label for="description">*描述</label>
<input name="description" id="description" type="text" value="<?= _v('description')?>"/><br/>

<label for="object_flag">来自表/视图</label>
<input name="object_flag" id="object_flag" type="checkbox" value="1"
    <?php if(_v('object_flag')) : echo 'checked'; endif;?>
    /><br/>

<label for="label_fieldname">说明字段</label>
<input name="label_fieldname" id="label_fieldname" type="text" value="<?= _v('label_fieldname')?>"/><br/>

<label for="value_fieldname">值字段</label>
<input name="value_fieldname" id="value_fieldname" type="text" value="<?= _v('value_fieldname')?>"/><br/>

<label for="source_view">源表/视图</label>
<select id="source_view" name="source_view">
<?php render_options_with_value('vl_tables',_v('source_view'))?>
</select>
<br/>

<label for="condition">查询条件</label>
<textarea name="condition" id="condition" type="text"><?= _v('condition')?></textarea><br/>

<label for="parent_id">父值集</label>
<select id="parent_id" name="parent_id">
    <option></option>
    <?php render_options_with_value('vl_valuelist',_v('parent_id'));?>
</select>
<br/>