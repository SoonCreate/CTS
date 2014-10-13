<!DOCTYPE html>
<html>
<head>
    <title>企业闭环系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
    <link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/sc/sc.css" />
    <link rel="stylesheet" href="resources/css/main.css" />
    <!-- Bootstrap-->
    <link href="resources/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/dojo/dojox/widget/Toaster/Toaster.css" >
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="resources/css/font-awesome.min.css" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" href="resources/css/font-awesome-ie7.min.css">
    <![endif]-->
    <script type="text/javascript">
    var dojoConfig = {
        parseOnLoad: true,
        async : true,
        packages: [
            { name: "cts", location: "/cts/resources/js/"}
        ]
    };
    </script>
    <!-- 加载dojo -->
    <script type="text/javascript" src="/dojo/dojo/dojo.js"></script>

    <script type="text/javascript">
        //全局变量
        var $env = new Object;
        var $ = new Object;
        var $dom = new Object;
        var $dijit = new Object;
       require(["dojo/parser",
               "dojo/dom",
               "dojo/query",
               "dijit/registry",
               "dojo/ready",
               "dojo/_base/fx",
               "dojo/dom-style",
                "dijit/form/Select",
                "dijit/form/TextBox",
                "dijit/form/ValidationTextBox",
                "dijit/Editor"
           ],
           function(parser,dom,query,registry,ready){
           ready(function(){
               $env = new Object;
               $ = query;
               $dom = dom;
               $dijit = registry;
           });
       });


    </script>
    <script type="text/javascript" src="resources/js/sc.js"></script>
<style type="text/css">
    #preloader {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 1em;
        background: #fff url('/cts/resources/images/loadingAnimation.gif') no-repeat center center;
        position: absolute;
        z-index: 999;
        font-size: 24px;
        font-weight: bold;
    }
</style>
 </head>
<body class="sc">

<div id="preloader">Loading Application...</div>

<div data-dojo-type="dijit/layout/BorderContainer" id="mainContainer"
     data-dojo-props="gutters:false">
    <div data-dojo-type="dijit/layout/ContentPane" id="headerPane"
         data-dojo-props="splitter:false, region:'top'">
        <div class="comlogo"><img src="resources/images/sclogo.png" style="height: 50px"/></div>
        <!--div class="headerline"></div-->

    </div>
    <div data-dojo-type="dijit/layout/BorderContainer" id="mainSplitter"
         data-dojo-props="liveSplitters: false, design: 'sidebar', region: 'center'">

        <div data-dojo-type="dijit/layout/TabContainer" id="mainTabContainer"
             data-dojo-props="region: 'center',tabPosition:'left-h'" class=" ">

            <?php if(isset($modules)):?>
            <?php  foreach($modules as $m) :?>
                    <div data-dojo-type="dojox/layout/ContentPane" id="<?= $m['module_id']?>"
                         title="<?= $m['module_desc']?>"
                         iconClass="<?= $m['module_display_class'] ? $m['module_display_class'] : 'icon-globe'?> icon-3x"
                         data-dojo-props=" href:'<?= $m['url']?>'"
                         onDownloadEnd = "refresh_env();"></div>
             <?php  endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>
<div data-dojo-type="dojox/widget/Toaster" data-dojo-props="positionDirection:'tr-left'"
     id="toaster">
</div>
</body>
</html>