<h1>角色信息修改</h1>
<form id="role_edit" method="post" action="<?= _url('role','edit')?>">
    <label for="role_name">*角色名</label><input name="role_name" id="role_name" type="text" value="<?= _v('role_name')?>" disabled/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"><?= _v('description')?></textarea>
    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <button type="submit">提交</button>
</form>
