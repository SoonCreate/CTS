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
    height: 28px;
    /*opacity: 0; /*Chrome、Safari、Firefox、Opera */
    /*filter: progid:DXImageTransform.Microsoft.Alpha(opacity=10); *//* IE6/IE7/8 */
    /*-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=40)";   /* IE8 */
    /*filter:Alpha(opacity=0,finishOpacity=0,style=0);*/
    float: left;
    text-align: center;
    margin-right: 120px;
    padding: 5px 5px 0 5px;
}
 .numcode{
     margin-left: 10px;
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
            <div class="DialogTitleBar">
                <img src="<?=base_url()?>resources/images/sclogo.png" />
                <h3>闭环系统用户登录</h3>
            </div>
            <div class="DialogPaneContent container-fluid" > 
                <form data-dojo-type="dijit/form/Form" class="form-horizontal" id="userForm" method="post" action="<?= _url('user','login')?>" >
                    <script type="dojo/on" data-dojo-event="submit">
                        return false;
                    </script>
                <dl class="row dl-horizontal">
                    <dt><label for="username">用户名：</label></dt>
                    <dd><input data-dojo-type="dijit/form/TextBox" name="username" id="username" /></dd>
                </dl>
                <dl class="row dl-horizontal">
                    <dt><label for="password">密码：</label></dt>
                    <dd><input data-dojo-type="dijit/form/TextBox" type="password"  name="password" id="password" /></dd>
                </dl>
                <dl class="row dl-horizontal">
                    <dt><label for="code">验证码：</label></dt>
                    <dd><input data-dojo-type="dijit/form/TextBox" name="code" class="codebox"
                                   id="code" trim="true" required="true" maxlength="4" regExp="[0-9]+"
                                   style="width: 50px" />
                        <img src="<?= _url('user','get_code') ?>"  class="numcode" id="getcode_num" title="看不清，点击换一张" align="absmiddle" />
                    </dd>
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


        //*远程验证用户密码匹配
        function submitForm(){
            require(["dojo/request","dojo/dom","dijit/registry","dojo/dom-construct","dojo/dom-form","dojo/domReady!"],
                function(request,dom,registry,domConstruct,domForm){
                    var mes = dom.byId("flashMessage");
                    request.post("<?= _url('user','login')?>",{
                        data: domForm.toObject("userForm"),
                        timeout : 2000,
                        handleAs : "json"
                    }).then(function(response){
                        if(response == "1")
                            mes.innerHTML = "你输入的验证码有误";
                        if(response == "2")
                            mes.innerHTML = "用户名或密码有误";

                    });

                });
        }


    </script>
</body>
</html>