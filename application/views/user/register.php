<h1>用户注册</h1>
<form id="register" method="post" action="<?= _url('user','register')?>">
    <label for="username">*用户名</label><input name="username" id="username" type="text"/><br/>
    <label for="password">*密码</label><input name="password" id="password" type="text"/><br/>
    <label for="repassword">*重复密码</label><input name="repassword" id="repassword" type="text"/><br/>
    <label for="order_type">您是我们公司的</label>

    <input name="order_type" id="customer" type="radio" value="customer" checked/><label for="customer">客户</label>
    <input name="order_type" id="vendor" type="radio" value="vendor"/><label for="vendor">供应商</label>
    <input name="order_type" id="employee" type="radio" value="employee"/><label for="employee">内部员工</label><br/>
    <button type="submit">提交</button>
</form>

