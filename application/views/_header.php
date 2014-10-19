<head>
    <title><?= full_name(_sess('uid'),false,false)?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="" type="image/x-icon" />
    <link rel="icon" href="" type=" image/png">
    <link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/sc/sc.css" />
<link rel="stylesheet" href="<?= base_url() ?>resources/css/main.css" />
<!-- Bootstrap-->
<link href="<?= base_url() ?>resources/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/dojo/dojox/widget/Toaster/Toaster.css" >
<link href="<?= base_url() ?>resources/css/Gridx.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet">
<!--[if IE 7]>
<link rel="stylesheet" href="resources/css/font-awesome-ie7.min.css">
<![endif]-->
<script type="text/javascript">
    var dojoConfig = {
        parseOnLoad: true,
        async : true,
        packages: [
            { name: "cts", location: "/cts/resources/js/"},
            { name: "sckj", location: "/cts/resources/js/dijit"}
        ]
    };
</script>
<!-- 加载dojo -->
<script type="text/javascript" src="/dojo/dojo/dojo.js"></script>

<script type="text/javascript">
//    history.forward();
//history.go(1);
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
            "dojo/request",
            "dojo/_base/fx",
            "dojo/dom-style",
            "sckj/form/Select",
            "sckj/form/TextBox",
            "sckj/Editor",
            "sckj/form/Button",
            "sckj/form/CheckBox",
            "sckj/form/DateTextBox",
            "sckj/form/RadioButton",
            "sckj/form/TimeTextBox",
            "sckj/Dialog",
            "sckj/Gridx",
            'gridx/allModules',
            "gridx/core/model/cache/Sync",
            "gridx/core/model/cache/Async",
            "dojo/data/ItemFileReadStore",
            "dojo/store/JsonRest",
            "dojo/data/ObjectStore"

        ],
        function(parser,dom,query,registry,ready,request){
            ready(function(){
                $env = new Object;
                $ = query;
                $dom = dom;
                $dijit = registry;
                $ajax = request;
            });
        });

    function url(s,parmas){
        var ciBaseUrl = "<?= site_url().'/'?>";
        var url =  ciBaseUrl + s;
        if(parmas){
            var i = 0;
            for(var key in parmas){
                if(i < 1){
                    url = url + '?'+ key + '=' + parmas[key];
                } else{
                    url = url+ '&'+ key  +'=' + parmas[key];
                }
                i ++ ;
            }
        }
        return url;
    }

</script>
<script type="text/javascript" src="<?= base_url() ?>resources/js/sc.js"></script>

</head>