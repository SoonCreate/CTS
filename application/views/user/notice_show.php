<div class="row paneltitle">
    <h3><?= get_label('vl_notice_type',$notice_type).'：'. $title ?></h3>
</div>
<div class="container-fluid userd">
    <p><?= $content ?> <?php
        if(_v('order_id')){
           echo  render_link(array('order','show',array('id'=>_v('order_id'))),label('go_to_order').':'._v('order_id'));
        }
        ?>

        <div style="float: right">
        <?php
        if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) {
            echo $created_by;
        }?>
        <br/>

        </div>
    <br/>
    <div style="float: right"><?php echo $creation_date ?></div>
    <br/>
    </p>
</div>
<script type="text/javascript">
    refresh_notice_count();
</script>