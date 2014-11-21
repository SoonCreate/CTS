<div class="main">
    <!--=== Content Part ===-->
    <div class="container">
        <!--Error Block-->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="error-v1">
                    <span class="error-v1-title">404</span>
                    <span><?= _v('heading') ?></span>
                    <p><?= _v('message')  ?></p>
                </div>
            </div>
        </div>
        <!--End Error Block-->
    </div>
</div>
<script type="text/javascript">
    dojoConfirm('<?=  _v('message'); ?>','<?= _v('heading') ?>',function(){
        <?php
            $callback = _v('callback');
            if($callback){
                echo $callback;
            }
        ?>
    },null,'E')
</script>