<?php foreach($objects as $o):?>
<a href="<?= _url('order','create',array('type'=>$o))?>"><?= get_label('ao_order_type',$o)?></a>
<?php endforeach;?>