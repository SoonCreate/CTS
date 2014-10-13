<!DOCTYPE html>
<html>
<head>
<title>企业闭环系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<link rel="stylesheet" type="text/css" href="/dojo/dojo/resources/dojo.css" />
<link rel="stylesheet" type="text/css" href="/dojo/dijit/themes/sc/sc.css" />
<link rel="stylesheet" href="<?=base_url()?>resources/css/main.css" />
<link href="<?=base_url()?>resources/css/bootstrap.css" rel="stylesheet">

<style type="text/css">

body{
    background-color: #BDC3C7;
}
#flashMessage{
    /*width: 300px;*/
    height: 20px;
    background-color: #FFFFCC;
    /*opacity: 0; /*Chrome、Safari、Firefox、Opera */
    /*filter: progid:DXImageTransform.Microsoft.Alpha(opacity=10); *//* IE6/IE7/8 */
    /*-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=40)";   /* IE8 */
    /*filter:Alpha(opacity=0,finishOpacity=0,style=0);*/
    float: left;
    text-align: center;
    margin-right: 120px;
    border: 1px solid #c65d09;
    padding: 5px 5px 0 5px;
}

</style>
<!-- 设置dojo参数 -->
<script type="text/javascript">
    var dojoConfig = {
        parseOnLoad: true,
        async : true
    };
</script>
<!-- 加载dojo -->
<script type="text/javascript" src="/dojo/dojo/dojo.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/sc.js"></script>

<script type="text/javascript">
    require(["dojo/parser", "dijit/Editor"]);
</script>


</head>
<body class="sc">
    <!--div class="row"-->
        <div class="login" >
            <form id="order_create" method="post" action="<?= _url('user','login')?>" onsubmit="return formSubmit(this);">
            <div class="DialogTitleBar">
                <img src="<?=base_url()?>resources/images/sclogo.png" />
                <h3>闭环系统用户登录</h3>
            </div>
            <div class="DialogPaneContent container-fluid" > 
                <form data-dojo-type="dijit/form/Form" class="form-horizontal" id="userForm" >
                    <script type="dojo/on" data-dojo-event="submit">
                        return false;
                    </script>
                <dl class="row dl-horizontal">
                    <dt><label for="username">用户名：</label></dt>
                    <dd><input data-dojo-type="dijit/form/TextBox" name="username" id="username" onblur="validateUsername(this)"/></dd>
                </dl>
                <dl class="row dl-horizontal">
                    <dt><label for="password">密码：</label></dt>
                    <dd><input data-dojo-type="dijit/form/TextBox" type="password"  name="password" id="password" /></dd>
                </dl>
                <dl class="row dl-horizontal">
                    <dt><label for="code">验证码：</label></dt>
                    <dd><!--img src="" id="getcode_num" title="看不清，点击换一张" align="absmiddle"/--><input data-dojo-type="dijit/form/TextBox" name="code" class="codebox"
                                   id="code" trim="true" required="true" maxlength="4" regExp="[0-9]+"
                                   style="width: 50px" onchange="validateCode(this)"/></dd>
                </dl>            
        </div>
        <div id="pro" >
            <div data-dojo-type="dijit/ProgressBar" style="width:400px;visibility:hidden" jsId="jsProgress" id="downloadProgress"></div>
            <!--div class="progress progress-success progress-striped" style="visibility:hidden" id="progress">
                <div class="bar" style="width: 5%"></div>
            </div-->
        </div>
        <div class="DialogPaneActionBar">
            <div id="flashMessage"></div>
        	<button data-dojo-type="dijit/form/Button"  id="logonpost"  name="logonpost" disabled="false" onclick="submitForm()"> <label>登录</label></button>
            <button data-dojo-type="dijit/form/Button" class="success" id="regpost" disabled="false"> <label>注册</label></button>
        </div>
        </form>
        <!--End Error Block-->
</div>

    <script type="text/javascript">
        require(["dojo/parser","dojo/dom","dojo/on","dojo/ready","dojo/domReady!"],function(parser,dom,on,ready){
            parser.parse();
            ready(function(){
                var node = dom.byId("regpost");
                on(node, "click", function(){
                    window.location.href="<?=base_url()?>index.php/user/register";
                });
            });
        });
        //远程验证用户名
        function validateUsername(obj,fun){
            if(obj.value != ""){
                require(["dojo/request","dojo/dom","dojo/domReady!"],
                    function(request,query,dom){
                        console.info("gs1");
                        request.get("<?= _url('user','validate_username')?>?username="+obj.value,{handleAs : "text"}).then(function(response){
                            if(response == '0'){
                                //obj.focus();
                                obj.set("state","Error");
                                //var mes = dom.byId("flashMessage");
                               //mes.innerHTML = "hahahslf";

                            }
                            else if(response =='1'){
                                //obj.focus();
                                //obj.set("state","warning");
                            }
                            else{
                                if(fun){
                                    fun();
                                }
                            }
                        });
                    });
            }
        }


/* this is test
        require([
            "dojo/dom",
            "dojo/dom-attr",
            "dojo/dom-style",
            "dijit/registry",
            "dijit/form/Button",
            "dijit/Tooltip",
            "dojo/on",
            "dojo/parser",
            "dojo/ready",
            "dojo/domReady!"

        ], function(dom, domAttr, domstyle, registry, Button,Tooltip, on ,parser,ready) {
            parser.parse();
            ready(function(){
                var reg = dom.byId("regpost");
                on(reg,"click",function(){
                });

                //以下是测试数据，待删除
                var nametip = new Tooltip({
                    connectId: ["username"]
                    //label: "the text for the tooltip"
                });
                //var username = registry.byId("username");
                //nametip.show( "sdfdsfd", dom.byId("flashMessage"), top);
                var logon = dom.byId("logonpost");
                //var regon = dom.byId("regpost");
                on(logon,"click",function(){

                    console.info("yyyy");
                    //logon.setAttribute("disabled","true");
                    //domAttr.remove("regpost","disabled");
                   // registry.byId('regpost').set('disabled',true);
                    //registry.byId('logonpost').set('disabled',true);
                    //registry.byId('logonname').set('disabled',true);
                    //registry.byId('logonpass').set('disabled',true);
                    //dom.byId('progress').setAttribute('style',"visibility:true");

                    //domAttr.set('regpost','disabled','false');
                });
            });
        });*/
    </script>
</body>
</html>