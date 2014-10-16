
<?= render_form_open('order','create') ?>
<div class="container-fluid userd">
    <?= render_select_with_options('severity','vl_severity');?>
    <?= render_select_with_options('frequency','vl_frequency');?>
    <?php if(isset($categories)) :?>
    <dl class="row dl-horizontal">
        <dt><?= lang('category') ;?></dt>
        <dd>
            <select name="category" id="category" data-dojo-type="sckj/form/Select">
                <?php foreach($categories as $c):?>
                    <option value="<?= $c?>"><?= get_label('vl_order_category',$c,$order_type)?></option>
                <?php endforeach;?>
            </select>
        </dd>
        <?= render_form_error('category')?>
    </dl>
     <?php endif; ?>
    <?= render_form_input('title',TRUE);?>
    <?= render_form_textarea('content',TRUE);?>
</div>
<?= render_form_header('contact_information');?>
<div class="container-fluid userd">
    <?php if(isset($contact_data)){?>
        <?= render_form_combobox('contact',$contact_data,TRUE,array('onchange'=>'_orderCreatesetValue(this)'));?>
    <?php }else{?>
        <?= render_form_input('contact',TRUE);?>
    <?php }?>

    <?= render_form_input('mobile_telephone',TRUE);?>
    <?= render_form_input('phone_number');?>
    <?= render_form_input('full_name');?>
    <?= render_form_input('address');?>
    <input name="order_type" id="order_type" type="hidden" value="<?= $order_type ?>"/>
    <br/><br/>
</div>

<?= render_button_group();?>
<?= render_form_close() ?>
<script type="text/javascript">
    function _orderCreatesetValue(object){
        var item = object.item;
        if(item){
            dijitObject('mobile_telephone').setValue(item["mobile_telephone"]);
            dijitObject('phone_number').setValue(item["phone_number"]);
            dijitObject('full_name').setValue(item["full_name"]);
            dijitObject('address').setValue(item["address"]);
        }
    }
</script>