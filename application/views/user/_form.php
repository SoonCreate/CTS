<dl class="row dl-horizontal">
    <dt><label for="full_name">*公司名称/姓名</label></dt>
    <dd><input name="full_name" id="full_name" type="text" value="<?= _v('full_name')?>" data-dojo-type="sckj/form/TextBox"/></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="contact">联系人</label></dt>
    <dd><input name="contact" id="contact" type="text" value="<?= _v('contact')?>" data-dojo-type="sckj/form/TextBox"/></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="sex">性别</label></dt>
    <dd><?php render_radio_with_value('sex','vl_sex',_v('sex'));?></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="email">EMAIL</label></dt>
    <dd><input name="email" id="email" type="text" value="<?= _v('email')?>" data-dojo-type="sckj/form/TextBox"/></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="mobile_telephone">手机号码</label></dt>
    <dd><input name="mobile_telephone" id="mobile_telephone" type="text" value="<?= _v('mobile_telephone')?>" data-dojo-type="sckj/form/TextBox"/></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="phone_number">固定电话</label></dt>
    <dd><input name="phone_number" id="phone_number" type="text" value="<?= _v('phone_number')?>" data-dojo-type="sckj/form/TextBox"/></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="address">地址</label></dt>
    <dd><input name="address" id="address" type="text" value="<?= _v('address')?>" data-dojo-type="sckj/form/TextBox"/></dd>
</dl>
<dl class="row dl-horizontal">
    <dt><label for="email_flag">通过邮件接收消息</label></dt>
    <dd><input name="email_flag" id="email_flag" type="checkbox" value="<?= _v('email_flag') || 1?>" <?php
        if(_v('email_flag')) : echo 'checked' ;endif;
        ?>/></dd>
</dl>
