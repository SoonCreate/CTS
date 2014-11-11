<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="" type="image/x-icon" />
<link rel="icon" href="" type=" image/png">

<script type="text/javascript">
    var dojoConfig = {
        parseOnLoad: true,
        async : true,
        packages: [
            { name: "cts", location: "<?= base_url() ?>/resources/js/"},
            { name: "sckj", location: "<?= base_url() ?>/resources/js/dijit"}
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
            "dojo/domReady!"],
        function(parser,dom,query,registry,ready,request){
            ready(function(){
                $ = query;
                $dom = dom;
                $dijit = registry;
                $ajax = request;
                console.info(<?= _v('initial_pass_flag')?>);
                <?php if(_v('initial_pass_flag')){
                    $goto = url_goto(array('user','change_password'));
                ?>
                dojoConfirm("您的账号密码为初始密码，请先修改密码！",null,function(){
                    goto("<?= $goto['url']?>",<?= $goto['module_id'] ?>,false,true);
                },null,"W");

                <?php }?>

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
<script type="text/javascript">
    //初始状态
    if($env == undefined){
        $env = new Object();
    }
    <?php if(_sess('cm')) :?>
    $env.cm = <?= _sess('cm')?>;
    <?php endif; ?>
    <?php if(_sess('mid')) :?>
    $env.mid = <?= _sess('mid')?>;
    <?php endif; ?>
    <?php if(_sess('fid')) :?>
    $env.fid = <?= _sess('fid')?>;
    <?php endif; ?>
</script>
<script type="text/javascript" src="<?= base_url() ?>resources/js/sc.js"></script>

<link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/sc/sc.css" />

<link rel="stylesheet" href="<?= base_url() ?>resources/css/main.css" />
<link href="<?php echo base_url(); ?>resources/css/gs.css" rel="stylesheet">
<!-- Bootstrap-->
<!--<link href="--><?php //base_url() ?><!--resources/css/bootstrap.css" rel="stylesheet">-->

<link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet">
<!--[if IE 7]>
<!--<link rel="stylesheet" href="resources/css/font-awesome-ie7.min.css">-->
<![endif]-->
<link rel="stylesheet" type="text/css" href="/dojo/dojox/widget/Toaster/Toaster.css" >
<link href="<?= base_url() ?>resources/css/Gridx.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<!--<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
<!--<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>-->
<![endif]-->
<?php $this->load->view('_ie6_fix');?>
