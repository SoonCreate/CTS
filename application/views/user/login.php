<!DOCTYPE html>
<html>
<?php $this->load->view('_header') ?>
<body class="sc">

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
                <dt><label for="username">用户名：</label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" name="username" id="username" /></dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="password">密码：</label></dt>
                <dd><input data-dojo-type="dijit/form/ValidationTextBox" type="password"  name="password" id="password" /></dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="code">验证码：</label></dt>
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
                <button data-dojo-type="dijit/form/Button" type="button" class="success" id="regpost" onclick="redirect('<?= _url('user','register')?>')">
                    <label>注册</label>
                </button>
            </div>
        </form>
        </div>

    </div>



    <!--End Error Block-->


<script type="text/javascript">
    function cFormSubmit(object){
        require(["dojo/dom-form","dojo/request"],function(domForm,request){
            var mes = $dom.byId("flashMessage");
            request.post(object.action, {
                // Send the username and password
                data: domForm.toObject(object),
                // Wait 2 seconds for a response
                timeout: 2000,
                handleAs : "json"
            }).then(function(response){
                    if(response == "1")
                        mes.innerHTML = "你输入的验证码有误";
                    if(response == "2")
                        mes.innerHTML = "用户名或密码有误";
                    if(response == "3"){
                        mes.innerHTML = "用户登录验证成功";
                        redirect("<?= _url('welcome','index')?>");
                    }
                },function(){
                    console.log('remote request error!');
                });
        });
        return false;
    }
</script>

</body>
</html>