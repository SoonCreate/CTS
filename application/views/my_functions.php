<h1>我的功能</h1>
<?php if(isset($functions)):?>
    <ul>
        <?php  foreach($functions as $fn) :?>
            <li>
                <?php render_link(_url('welcome','go',array('cm'=>$fn['id'])),$fn['function_desc'])?>
            </li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>