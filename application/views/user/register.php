<!DOCTYPE html>
<html>
<?php $this->load->view('_header') ?>
<body class="sc">
    <div class="regheader">
        <div class="reglogo"><img src="<?= base_url() ?>resources/images/sclogo.png" style="height: 50px"/></div>
        <!--div class="headerline"></div-->
    </div>

    <div  class="regcontent" >
        <div class="regcontent-tit">
            <h4>用户注册</h4>
        </div>
        <form id="register" method="post" action="<?= _url('user','register')?>">
        <div class="container-fluid userd">
            <dl class="row dl-horizontal">
                <dt><label for="username">*用户名</label></dt>
                <dd>
                    <input name="username" id="username" type="text" data-dojo-type="sckj/form/TextBox"/>
                </dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="password">*密码</label></dt>
                <dd>
                    <input name="password" id="password" type="text" data-dojo-type="sckj/form/TextBox"/>
                </dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="repassword">*重复密码</label></dt>
                <dd>
                    <input name="repassword" id="repassword" type="text" data-dojo-type="sckj/form/TextBox"/>
                </dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="full_name">*公司名称/姓名</label></dt>
                <dd>
                    <input name="full_name" id="full_name" type="text" data-dojo-type="sckj/form/TextBox"/>
                </dd>
            </dl>
            <dl class="row dl-horizontal">
                <dt><label for="order_type">您是我们公司的</label></dt>
                <dd>
                    <select name="order_type" id="order_type" data-dojo-type="sckj/form/Select">
                        <option value ='customer'>客户</option>
                        <option value ='vendor'>供应商</option>
                        <option value ='employee'>内部员工</option>
                    </select>
                </dd>
            </dl>
            <!--label for="order_type">您是我们公司的</label>
            <input name="order_type" id="customer" type="radio" value="customer" checked/><label for="customer">客户</label>
            <input name="order_type" id="vendor" type="radio" value="vendor"/><label for="vendor">供应商</label>
            <input name="order_type" id="employee" type="radio" value="employee"/><label for="employee">内部员工</label><br/-->
        </div>
        <div class="row panelbottom">
            <button type="submit" data-dojo-type="sckj/form/Button" class="success bigbtn"><i class="icon-circle-arrow-right"></i><label>提交</label></button>
        </div>
        </form>
    </div>



</body>

