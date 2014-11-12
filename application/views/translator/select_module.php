<ul class="applist row">
    <?php foreach ( $masterModules as $masterModule ) {
        $hidden['langModule'] = $masterModule;
        if ( ! in_array( $masterModule, $slaveModules ) ) {
            echo $masterModule . " module not found";
        }else{?>
        <li>
            <?= render_link(array('translator','index',$hidden),'
         <div class="icon"><i class="icon-tasks icon-3x"></i></div>
            <div class="text">
                '.$masterModule.'
            </div>
        ') ?>

        </li>
    <?php }
    }?>
</ul>