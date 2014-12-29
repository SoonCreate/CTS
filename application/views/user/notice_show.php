<div class="row paneltitle">
    <h3><?= $title?></h3>
</div>
<div class="container-fluid userd">
    <p><?= $content ?> <?php
        if(_v('order_id')){
           echo  render_link(array('order','show',array('id'=>_v('order_id'))),label('go_to_order').':'._v('order_id'));
        }
        ?></p>
</div>
<script type="text/javascript">
    refresh_notice_count();
</script>