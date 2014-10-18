<style type="text/css">
    @import "/dojo/dojox/form/resources/Rating.css";

    #myRating .dojoxRatingStar{
        background-image:url(/dojo/dijit/themes/tundra/images/dndCopy.png);
        background-position:center center;
        background-repeat:no-repeat;
        background-color:lightgrey;
        width:16px;
        height:16px;
        padding:0.5em;
    }

    #myRating .dojoxRatingStarChecked {
        background-image:url(/dojo/dijit/themes/tundra/images/dndNoMove.png);
    }
    #myRating .dojoxRatingStarHover {
        background-image:url(/dojo/dijit/themes/tundra/images/dndNoMove.png);
    }
</style>
<?= render_form_open('order','feedback') ?>
<?= render_form_header('please_score_for_this_service');?>
<?php foreach($stars as $s){?>
<dl class="row dl-horizontal"> <dt>
    <label><?= $s['label']?></label>
    </dt><dd>
    <div data-dojo-type="dojox/form/Rating" data-dojo-props="numStars:5,value:<?= $s['value']?>" name="stars[]"></div>
     </dd>
    </dl>
<?php }?>

<?= render_form_textarea('content');?>
<?= render_form_hidden('id');?>
<?= render_button_group();?>
<?= render_form_close() ?>