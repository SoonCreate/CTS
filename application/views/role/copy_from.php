<h1>角色拷贝</h1>
<form id="role_copy" method="post" action="<?= _url('role','copy_from')?>">
    <label for="from">*拷贝来自角色</label>
    <select id="from" name="from">
        <?= render_options('vl_roles')?>
    </select>
    <br/>
    <label for="role_name">*新角色名</label><input name="role_name" id="role_name" type="text" /><br/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"></textarea><br/>
    <button type="submit">提交</button>
</form>