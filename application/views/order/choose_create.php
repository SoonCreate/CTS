<ul class="applist row">
<?php foreach($objects as $o):?>

    <li>
        <div class="icon"><i class=" icon-file-alt icon-3x"></i></div>
        <div class="text"><?= render_link(array('order','create',array('type'=>$o)),get_label('ao_order_type',$o))?></div>
    </li>
<?php endforeach;?>
</ul>