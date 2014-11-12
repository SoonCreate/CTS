<?php $this->load->view('order/_feedback_style'); ?>
<?= render_form_header('please_score_for_this_service');?>
<?= render_form_open('order','feedback') ?>

<div class="container-fluid userd">
    <?php foreach($stars as $s){?>
        <dl class="row dl-horizontal"> <dt>
                <label><?= $s['feedback_desc']?></label>
            </dt><dd>
                <div data-dojo-type="dojox/form/Rating" data-dojo-props="numStars:<?= _config('feedback_star')?>,
    value:<?= $s['stars']?>" name="star_<?= $s['feedback_type']?>"></div>
            </dd>
        </dl>
    <?php }?>

    <?= render_form_textarea('content_plus');?>
    <?= render_form_hidden('feedback_id',$id);?>
    <?= render_form_hidden('id',$order_id);?>
</div>
<?= render_button_group();?>
<?= render_form_close() ?>