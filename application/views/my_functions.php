<?php if(isset($functions)):?>
    <ul class="applist row">
        <?php  foreach($functions as $fn) :
            $label = $fn['function_desc'];
            if(env_language() == 'en-us'){
                $label = label($fn['function_name']);
            }
            ?>
            <li>
                <?= render_link(array($fn['controller'],$fn['action']),'
                 <div class="icon"><i class="'.$fn['function_display_class'].' icon-3x"></i></div>
                    <div class="text">
                        '.$label.'
                    </div>
                ')?>

            </li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>