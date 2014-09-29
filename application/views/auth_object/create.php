<h1>权限对象创建</h1>
<form id="auth_object_create" method="post" action="<?= _url('auth_object','create')?>">
    <label for="object_name">*对象名称</label><input name="object_name" id="object_name" type="text"/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"></textarea>
    <button type="submit">提交</button>
</form>
