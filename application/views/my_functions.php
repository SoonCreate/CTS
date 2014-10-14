<div class="headline">
    <h2>我的功能</h2>
</div>
<?php if(isset($functions)):?>
    <ul class="applist row">
        <?php  foreach($functions as $fn) :?>
            <li>
                <div class="icon"><i class="icon-tasks icon-3x"></i></div>
                <div class="text">
                <?php render_link(_url('welcome','go',array('cm'=>$fn['id'])),$fn['function_desc'])?>
                </div>
            </li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>