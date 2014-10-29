<link href="<?= base_url() ?>resources/css/font-awesome.min.css" rel="stylesheet">
<!--[if IE 7]>
<link rel="stylesheet" href="resources/css/font-awesome-ie7.min.css">
<![endif]-->
<link rel="stylesheet" type="text/css" href="/dojo/dojox/widget/Toaster/Toaster.css" >
<link href="<?= base_url() ?>resources/css/Gridx.css" rel="stylesheet">
<script type="text/javascript">
    //    history.forward();
    //history.go(1);
    //全局变量
    var $env = new Object;
    var $ = new Object;
    var $dom = new Object;
    var $dijit = new Object;
    require(["dojo/dom",
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
//            'gridx/allModules',
            "gridx/core/model/cache/Sync",
            "gridx/core/model/cache/Async",
            "dojo/data/ItemFileReadStore",
            "dojo/store/JsonRest",
            "dojo/data/ObjectStore",
            "dojo/domReady!"

        ],
        function(dom,query,registry,ready,request){
            ready(function(){
                $env = new Object;
                $ = query;
                $dom = dom;
                $dijit = registry;
                $ajax = request;

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