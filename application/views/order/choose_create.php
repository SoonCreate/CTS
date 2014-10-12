<?php foreach($objects as $o):?>
    <?php render_link(_url('order','create',array('type'=>$o)),get_label('ao_order_type',$o))?>
<?php endforeach;?>