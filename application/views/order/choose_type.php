<ul class="applist row">
    <?php foreach($objects as $o):?>

        <li>
            <?= render_link(array('order','index',array('order_type'=>$o)),
                '<div class="icon"><i class=" icon-file-alt icon-3x"></i></div>
        <div class="text">
            '.get_label('ao_order_type',$o).'
        </div>')?>
        </li>
    <?php endforeach;?>
</ul>