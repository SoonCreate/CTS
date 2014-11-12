<ul class="applist row">
<?php foreach ( $languages as $language ) {
    $hidden['slaveLang'] = $language;
?>
    <li>
        <?= render_link(array('translator','index',$hidden),'
         <div class="icon"><i class="icon-tasks icon-3x"></i></div>
            <div class="text">
                '.$language.'
            </div>
        ') ?>

    </li>
<?php }?>
</ul>
