<h1>权限对象项目修改</h1>
<form id="item_edit" method="post" action="<?= _url('role','profile_object_item_edit')?>">
    <label for="auth_value">*值</label>
    <input name="auth_value" id="auth_value" type="text" value="<?= _v('auth_value')?>"/><br/>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <button type="submit">提交</button>
</form>
