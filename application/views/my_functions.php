<div class="headline">
    <h2><?= label('index')?></h2>
</div>
<?php if(isset($functions)):?>
    <ul class="applist row">
        <?php  foreach($functions as $fn) :
            $icon = $fn['function_display_class'] ? $fn['function_display_class'] : 'icon-tasks';
            ?>
            <li>
                <?= render_link(_url($fn['controller'],$fn['action'],array('cm'=>$fn['id'])),'
                 <div class="icon"><i class="'.$icon.' icon-3x"></i></div>
                    <div class="text">
                        '.$fn['function_desc'].'
                    </div>
                ')?>

            </li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>