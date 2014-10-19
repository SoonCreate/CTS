<!DOCTYPE html>
<html>
<head>
    <title>演示页面</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
    <link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/sc/sc.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/resources/css/main.css" />
    <!-- Bootstrap-->
    <link href="<?= base_url() ?>/resources/css/bootstrap.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="<?= base_url() ?>/resources/css/font-awesome.min.css" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?= base_url() ?>/resources/css/font-awesome-ie7.min.css">
    <![endif]-->

    <?php $this->load->view('_ie6_fix')?>
    <script type="text/javascript">
        var dojoConfig = {
            parseOnLoad: true,
            async : true
        };
    </script>
    <!-- 加载dojo -->
    <script type="text/javascript" src="/dojo/dojo/dojo.js"></script>



</head>
<body>
<div id="demo">
    <div id="header">
        <div class="comlogo" style="padding-left:0px !important"><img src="<?= base_url() ?>resources/images/sclogo.png" style="height: 50px"/></div>
    </div>
    <div id="demowarp">
        <ul class="applist">
            <?php foreach($users as $u){?>
                <li>
                    <a href="<?= _url('welcome','demo_env',array('id'=>$u['id']))?>">
                        <div class="icon"><i class="icon-user icon-3x"></i></div>
                        <div class="text"><?= $u['full_name']?></div>
                    </a>
                </li>
            <?php }?>

        </ul>
    </div>
    </body>
</html>