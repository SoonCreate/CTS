<?php render_form_open('order','create') ?>
<div class="container-fluid userd">
    <?php render_select_with_options('severity','vl_severity');?>
    <?php render_select_with_options('frequency','vl_frequency');?>
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
        <?php render_form_error('category')?>
    </dl>
     <?php endif; ?>
    <?php render_form_input('title',TRUE);?>
    <?php render_form_textarea('content',TRUE);?>
</div>
<?php render_form_header('contact_information');?>
<div class="container-fluid userd">
    <?php render_form_input('contact',TRUE);?>
    <?php render_form_input('mobile_telephone',TRUE);?>
    <?php render_form_input('phone_number');?>
    <?php render_form_input('full_name');?>
    <?php render_form_input('address');?>
    <input name="order_type" id="order_type" type="hidden" value="<?= $order_type ?>"/>
</div>
<div class="row panelbottom">
    <?php render_submit_button();?>
</div>
<?php render_form_close() ?>