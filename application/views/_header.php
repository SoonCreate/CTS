<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="" type="image/x-icon" />
<link rel="icon" href="" type=" image/png">
<link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/sc/sc.css" />
<link rel="stylesheet" href="<?= base_url() ?>resources/css/main.css" />
<!-- Bootstrap-->
<link href="<?= base_url() ?>resources/css/bootstrap.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
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
<script type="text/javascript" src="<?= base_url() ?>resources/js/sc.js"></script>
<script type="text/javascript">
    require(["dojo/parser"]);
;</script>