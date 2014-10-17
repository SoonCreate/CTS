<?php foreach($objects as $o):?>
    <?= render_link(array('order','create',array('type'=>$o)),get_label('ao_order_type',$o))?>
<?php endforeach;?>