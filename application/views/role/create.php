<h1>角色创建</h1>
<form id="role_create" method="post" action="<?= _url('role','create')?>">
    <label for="role_name">*角色名</label><input name="role_name" id="role_name" type="text" />
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"></textarea>
    <button type="submit">提交</button>
</form>

