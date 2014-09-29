<h1>权限对象修改</h1>
<form id="auth_object_edit" method="post" action="<?= _url('auth_object','edit')?>">
    <label for="object_name">*对象名称</label><input name="object_name" id="object_name" type="text" value="<?= _v('object_name')?>" disabled/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"><?= _v('description')?></textarea>
    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <button type="submit">提交</button>
</form>
