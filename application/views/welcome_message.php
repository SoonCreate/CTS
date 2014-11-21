<!DOCTYPE html>
<head>
    <link href="<?php echo base_url(); ?>resources/css/main.css" rel="stylesheet">
</head>
<body>

<div class="login" >
    <div class="loginTitleBar">
        <h3>Error:</h3>
    </div>
    <div class="loginPaneContent container-fluid" >
        <div class="errorContent">
            <p><?= _v('heading') ?></p>
            <p><?= _v('message')  ?></p>
        </div>
    </div>
    <!--End Error Block-->
</div>

</body>
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