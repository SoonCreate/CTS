<?= render_form_input('description',TRUE);?>
<dl class="row dl-horizontal">
    <dt><label for="object_flag">来自表/视图</label></dt>
    <dd><input name="object_flag" id="object_flag"  data-dojo-type="sckj/form/CheckBox" type="checkbox" value="1" <?php
        if(_v('object_flag')) : echo 'checked' ;endif;
        ?>/></dd>
</dl>

<?= render_form_input('label_fieldname');?>
<?= render_form_input('value_fieldname');?>

<?= render_select_with_options('source_view','vl_tables');?>

<?= render_form_textarea('condition')?>

<?= render_select_add_options('parent_id',render_options('vl_valuelist',null,false,true));?>