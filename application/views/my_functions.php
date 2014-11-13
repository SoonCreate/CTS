<?php if(isset($functions)):?>
    <ul class="applist row">
        <?php  foreach($functions as $fn) :
            $label = $fn['function_desc'];
            if(env_language() == 'en-us'){
                $label = label($fn['function_name']);
            }
            $icon = $fn['function_display_class'] ? $fn['function_display_class'] : 'icon-tasks';
            ?>
            <li>
                <?= render_link(_url($fn['controller'],$fn['action'],array('cm'=>$fn['id'])),'
                 <div class="icon"><i class="'.$icon.' icon-3x"></i></div>
                    <div class="text">
                        '.$label.'
                    </div>
                ')?>

            </li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>