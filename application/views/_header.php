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
<script type="text/javascript" src="<?= base_url() ?>/../../dojo/dojo/dojo.js"></script>

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
            "dojo/on",
            "dojo/mouse",
            "dojo/dom-class",
            "dijit/popup",
            "dijit/Menu",
            "dijit/MenuItem",
            "dojo/dom-construct",
            "dijit/form/Button",
            "dojo/domReady!"],
        function(parser,dom,query,registry,ready,request,on,mouse,domClass,popup,Menu,MenuItem,domConstruct,Button){
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

                var tablistNode = registry.byId("mainTabContainer").tablist.containerNode;

                //在第一个node之前插入按钮
                var backButton = new Button({
                    id : "wsoGoBack",
                    iconClass : "icon-reply icon-large"
                    onclick : function(){
                        goback();
                    },
                    showLabel : false,
                    style : "float:right;margin: 0 10px 10px 0;"
                });
                backButton.startup();
                domConstruct.place(backButton.domNode,tablistNode,"first");

                //监控左侧导航按钮
                dojo.forEach(tablistNode.childNodes,function(node){
                    //鼠标移动上去时弹出菜单
                    on(node,mouse.enter,function(evt){
                        _navStartup(node);
                    });
                    //鼠标点击时弹出菜单
                    on(node,'click',function(evt){
                        _navStartup(node);
                    });
                });

            });
            _navStartup  = function(node){
                //只有被打开的页签才显示菜单项
                if(domClass.contains(node,"dijitTabChecked")){
                    //远程加载菜单
                    request.get(url("welcome/module_function_list",{mid : $env.mid}),{handleAs : "json"}).then(function(data){
                        //长度等于1无需显示菜单
                        if(data && data.length > 1){
                            var pMenu = new Menu({
                                //失去焦点时隐藏
                                onBlur : function () {
                                    popup.close(this);
                                    this.destroy();
                                    this.destroyRecursive();
                                }
                            });

                            for(var i=0;i<data.length;i++){
                                var fn = data[i];
                                pMenu.addChild(new MenuItem({
                                    label : fn["function_desc"],
                                    iconClass : "dijitEditorIcon icon-2x " + fn["function_display_class"],
                                    fn : fn,
                                    onClick : function(){
                                        var fun = this.fn;
                                        goto(url(fun["controller"] + "/" + fun["action"]),$env.mid);
                                        //点击关闭当前
                                        popup.close(this);
                                        pMenu.destroy();
                                        pMenu.destroyRecursive();
                                    }
                                }));
                            }
                            popup.open({
                                popup: pMenu,
                                around: node,
                                orient : [ "after"]
//                                x: 10,
//                                y: 10
//                                onExecute: null,
//                                onCancel: null,
//                                orient: pMenu.isLeftToRight() ? 'L' : 'R'
                            });
                            //默认聚焦
                            pMenu.focus();
                        }
                    });

                }
            }
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
        return encodeURI(url);
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
<script type="text/javascript" src="<?= base_url() ?>resources/js/toolkit.js"></script>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/../../dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/../../dojo/dijit/themes/sc/sc.css" />

<link rel="stylesheet" href="<?= base_url() ?>resources/css/main.css" />
<link href="<?php echo base_url(); ?>resources/css/gs.css" rel="stylesheet">
<!-- Bootstrap-->
<!--<link href="--><?php //base_url() ?><!--resources/css/bootstrap.css" rel="stylesheet">-->

<link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet">
<!--[if IE 7]>
<!--<link rel="stylesheet" href="resources/css/font-awesome-ie7.min.css">-->
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/../../dojo/dojox/widget/Toaster/Toaster.css" >
<link href="<?= base_url() ?>resources/css/Gridx.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<!--<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
<!--<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>-->
<![endif]-->
<?php $this->load->view('_ie6_fix');?>
