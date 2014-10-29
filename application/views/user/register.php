<!DOCTYPE html>
<html>
<head>
    <title><?= label('version')?></title>
    <?php $this->load->view('_header') ?>
</head>
<body class="sc">
    <div class="regheader">
        <div class="reglogo"><img src="<?= base_url() ?>resources/images/sclogo.png" style="height: 50px"/></div>
        <!--div class="headerline"></div-->
    </div>

    <div  class="regcontent" >
        <div class="regcontent-tit">
            <h4>用户注册</h4>
        </div>
        <?= render_form_open('user','register')?>
        <div class="container-fluid userd">
            <?= render_form_input('username',true)?>
            <?= render_form_password('password',true)?>
            <?= render_form_password('repassword',true)?>
            <?= render_form_input('full_name',true)?>
            <?= render_radio('user_type','您是我们公司的','vl_register_select')?>
        </div>
        <div class="row panelbottom">
            <button type="submit" data-dojo-type="sckj/form/Button" class="success bigbtn"><i class="icon-circle-arrow-right"></i><label>提交</label></button>
        </div>
        <?= render_form_close()?>
    </div>
    <div data-dojo-type="dojox/widget/Toaster" data-dojo-props="positionDirection:'tr-left'"
         id="toaster">
    </div>
</body>

