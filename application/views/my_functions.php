<h1>我的功能</h1>
<?php if(isset($functions)):?>
    <ul>
        <?php  foreach($functions as $fn) :?>
            <li><a href="<?= _url($fn['controller'],$fn['action'])?>"><?= $fn['function_desc']?></a></li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>