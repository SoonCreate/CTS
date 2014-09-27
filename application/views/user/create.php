<h1>用户创建</h1>
<form id="user_create" method="post" action="<?= _url('user','create')?>">
    <label for="username">*用户名</label><input name="username" id="username" type="text"/>
    <label for="password">*密码</label><input name="password" id="password" type="text"/>
    <label for="repassword">*重复密码</label><input name="repassword" id="repassword" type="text"/>
    <label for="contact">*联系人</label><input name="contact" id="contact" type="text"/>
    <label for="email">EMAIL</label><input name="email" id="email" type="text"/>
    <label for="mobile_telephone">*手机号码</label><input name="mobile_telephone" id="mobile_telephone" type="text"/>
    <label for="phone_number">固定电话</label><input name="phone_number" id="phone_number" type="text"/>

    <label for="company_name">公司名称/员工名称</label><input name="full_name" id="company_name" type="text"/>
    <label for="address">地址</label><input name="address" id="address" type="text"/>
    <label for="email_flag">通过邮件接收消息</label><input name="email_flag" id="email_flag" type="checkbox" value="1"/>
    <button type="submit">提交</button>
</form>

