<!DOCTYPE html>
<html>
<head>
    <title><?= _config('logo_text') ?></title>
    <?php $this->load->view('_header') ?>
</head>
<body class="sc">

<script type="text/javascript">
    require(["dojo/dom","dojo/on","dojo/domReady!"],function(dom,on){
        var node = dom.byId("getcode_num");
        on(node, "click", function(e){
            node.src = '<?= _url('user','get_code?num=')?>' + Math.random();
        });
    });
</script>

<style type="text/css">

    body{
        background-color: #BDC3C7;
    }
    #flashMessage{
        width: 220px;
        height: 28px;
        /*opacity: 0; /*Chrome、Safari、Firefox、Opera */
        /*filter: progid:DXImageTransform.Microsoft.Alpha(opacity=10); *//* IE6/IE7/8 */
        /*-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=40)";   /* IE8 */
        /*filter:Alpha(opacity=0,finishOpacity=0,style=0);*/
        float: left;
        text-align: center;
        padding: 5px 5px 0 5px;
        color:red;
    }
    .numcode{
        margin-left: 10px;
    }
    .dijitTooltip{
        display: none !important;
    }

</style>
<!--div class="row"-->
<div class="login" >
    <div class="loginTitleBar">
        <img src="<?= base_url() ?>resources/images/logo.png" style="height: 35px"/>
        <h3><?= _config('logo_text') ?></h3>
    </div>
    <div class="loginPaneContent container-fluid" >
        <form class="form-horizontal" id="userForm" method="post" action="<?= _url('user','login')?>" onsubmit="return cFormSubmit(this);" >
            <dl class="row dl-horizontal">
                <dt><label for="username"><?= label('username')?></label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" name="username" id="username" required trim="true" /></dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="password"><?= label('password')?></label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" type="password"  name="password" id="password" required trim="true" /></dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="code"><?= label('code')?></label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" name="code" class="codebox"
                           id="code" trim="true" required="true" maxlength="4" regExp="[0-9]+"
                           style="width: 50px" />
                    <img src="<?= _url('user','get_code') ?>"  class="numcode" id="getcode_num" title="看不清，点击换一张" align="absmiddle" />
                </dd>
            </dl>
            <div id="pro" >
                <div  data-dojo-type="dijit/ProgressBar" style="width:398px;visibility:hidden"
                      id="downloadProgress" data-dojo-props="maximum:10" ></div>
                <!--class="progress progress-success progress-striped" visibility:hidden -->
            </div>
            <div class="loginPaneActionBar">
                <div id="flashMessage"></div>
                <button data-dojo-type="dijit/form/Button" type="submit" id="logonpost"  name="logonpost">
                    <label><?= label('login')?></label>
                </button>
                <?php if(_config('allow_register')){?>
                <button data-dojo-type="dijit/form/Button" type="button" class="success" id="regpost" onclick="redirect('<?= _url('user','register')?>')">
                    <label><?= label('register')?></label>
                </button>
                <?php }?>
            </div>
        </form>
        </div>

    </div>



    <!--End Error Block-->


<script type="text/javascript">
    var i = 0;
    var toUrl = "";
require(["dojo/dom-form","dojo/request","dojo/dom","dijit/registry","dojo/dom-style"],
    function(domForm,request,dom,registry,domStyle){
    cFormSubmit = function(object){
        var mes = dom.byId("flashMessage");
        if(registry.byId("username").validate() && registry.byId("password").validate() &&  registry.byId("code").validate()){
            request.post(object.action, {
                // Send the username and password
                data: domForm.toObject(object),
                // Wait 2 seconds for a response
                timeout: 2000,
                handleAs : "json"
            }).then(function(response){
                //先清空
                mes.innerHTML = "";

                //处理消息
                if("message" in response ){
                    var output = "";
                    for(var i=0;i < response["message"].length;i++){
                        var message = response["message"][i];
                        if(message["type"] == "E"){
                            output = output + message["content"];
                        }
                    }
                    mes.innerHTML = output;
                }else{
                    //处理跳转
                    if("redirect" in response ){
                        var logonpost = $dijit.byId("logonpost");
                        var regpost = $dijit.byId("regpost");
                        var username = $dijit.byId("username");
                        var password = $dijit.byId("password");
                        var code = $dijit.byId("code");
                        logonpost.set("disabled","disabled");
                        regpost.set("disabled","disabled");
                        username.set("disabled","disabled");
                        password.set("disabled","disabled");
                        code.set("disabled","disabled");
                        toUrl = response["redirect"]["url"];
                        var downloadProgress = $dijit.byId("downloadProgress");
                        downloadProgress.set("style","visibility:visible");
                        perLoading();
                        download();
                    }
                }

            },function(){
                console.log('remote request error!');
            });
        }
        return false;
    };

    download = function(){
        var downloadProgress = $dijit.byId("downloadProgress");
        downloadProgress.set({value: ++i});
        if(i < 10){
            setTimeout(download, 100 + Math.floor(Math.random() * 1000));
        }else{
            //处理跳转
            redirect(toUrl);
        }
    };
});
    //预加载
    function perLoading(){
        require(["dojo/ready",
            "dojo/_base/fx",
            "dojo/dom-style",
            "sckj/form/Select",
            "sckj/form/TextBox",
            "sckj/form/ScTextBox",
            "sckj/form/Textarea",
            "sckj/Editor",
            "sckj/form/Button",
            "sckj/form/CheckBox",
            "sckj/form/DateTextBox",
            "sckj/form/RadioButton",
            "sckj/form/TimeTextBox",
            "sckj/Dialog",
            "sckj/Gridx",
            "sckj/DataGrid",
            "sckj/Toolbar",
            "gridx/core/model/cache/Sync",
            "gridx/core/model/cache/Async",
            "dojo/data/ItemFileReadStore",
            "dojo/store/JsonRest",
            "dojo/data/ObjectStore",
            "dijit/layout/BorderContainer",
            "dijit/layout/TabContainer",
            "dojox/layout/ContentPane",
            "dojox/widget/Toaster",
            "dijit/layout/StackController",
            "dijit/layout/StackContainer",
            "dijit/layout/LayoutContainer",
            "dijit/layout/ScrollingTabController",
            "dijit/layout/TabController",
            "dijit/Menu",
            "gridx/allModules"
        ],function(ready){
            ready(function(){
                i = 5;
            });
        });
    }
</script>

<?php $this->load->view('_footer') ?>
</body>
</html>