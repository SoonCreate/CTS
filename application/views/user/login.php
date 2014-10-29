<!DOCTYPE html>
<html>
<head>
    <title><?= label('version')?></title>
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
    .dijitTooltip{
        display: none !important;
    }

</style>
<!--div class="row"-->
<div class="login" >
    <div class="DialogTitleBar">
        <img src="<?=base_url()?>resources/images/sclogo.png" />
        <h3>闭环系统用户登录</h3>
    </div>
    <div class="DialogPaneContent container-fluid" >
        <form class="form-horizontal" id="userForm" method="post" action="<?= _url('user','login')?>" onsubmit="return cFormSubmit(this);" >
            <dl class="row dl-horizontal">
                <dt><label for="username">用户名</label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" name="username" id="username" required trim="true" /></dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="password">密码</label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" type="password"  name="password" id="password" required trim="true" /></dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="code">验证码</label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" name="code" class="codebox"
                           id="code" trim="true" required="true" maxlength="4" regExp="[0-9]+"
                           style="width: 50px" />
                    <img src="<?= _url('user','get_code') ?>"  class="numcode" id="getcode_num" title="看不清，点击换一张" align="absmiddle" />
                </dd>
            </dl>
            <div id="pro" >
                <!--div data-dojo-type="dijit/ProgressBar" style="width:400px;visibility:hidden" jsId="jsProgress" id="downloadProgress"></div>
                <div class="progress progress-success progress-striped" style="visibility:hidden" id="progress">
                    <div class="bar" style="width: 5%"></div>
                </div-->
            </div>
            <div class="DialogPaneActionBar">
                <div id="flashMessage"></div>
                <button data-dojo-type="dijit/form/Button" type="submit" id="logonpost"  name="logonpost">
                    <label>登录</label>
                </button>
                <?php if(_config('allow_register')){?>
                <button data-dojo-type="dijit/form/Button" type="button" class="success" id="regpost" onclick="redirect('<?= _url('user','register')?>')">
                    <label>注册</label>
                </button>
                <?php }?>
            </div>
        </form>
        </div>

    </div>



    <!--End Error Block-->


<script type="text/javascript">
    function cFormSubmit(object){
        require(["dojo/dom-form","dojo/request","dojo/dom","dijit/registry"],function(domForm,request,dom,registry){
            var mes = dom.byId("flashMessage");
            if(registry.byId("username").validate() && registry.byId("password").validate() &&  registry.byId("code").validate()){
                request.post(object.action, {
                    // Send the username and password
                    data: domForm.toObject(object),
                    // Wait 2 seconds for a response
                    timeout: 2000,
                    handleAs : "json"
                }).then(function(response){
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
                    }

                    //处理跳转
                    if("redirect" in response ){
                        redirect(response["redirect"]["url"]);
                    }

                },function(){
                    console.log('remote request error!');
                });
            }
        });
        return false;
    }
</script>

</body>
</html>