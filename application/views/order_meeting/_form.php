<?= render_form_input('title',TRUE);?>
<?= render_form_datetextbox('start_date',TRUE);?>
<input data-dojo-type="sckj/form/TimeTextBox" name="start_time" id="start_time" value="<?= _v('start_time')?>" />
<?= render_form_datetextbox('end_date',TRUE);?>
<input data-dojo-type="sckj/form/TimeTextBox" name="end_time" id="end_time" value="<?= _v('end_time')?>" />
<?= render_form_input('site',TRUE);?>
<?= render_form_input('anchor',TRUE);?>
<?= render_form_input('recorder');?>
<?= render_form_input('actor',TRUE);?>
<?= render_form_textarea('discuss');?>
<?= render_form_input('order_id',TRUE)?>
以英文“,”分隔可关联多个投诉单
<br/>
<br/>
<br/>
<br/>
<script type="text/javascript">
    function showOrderSelectDialog(){
        console.info(11);
    }
</script>
