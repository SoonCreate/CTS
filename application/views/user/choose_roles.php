<h1>角色选择</h1>
<form id="choose_roles" method="post" action="<?= _url('user','choose_roles')?>">
    <?php foreach($roles as $role) :?>
        <input type="checkbox" name="roles[]" id="role_<?= $role['id'] ?>" value="<?= $role['id']?>" <?= $role['checked']?>/>
        <label for="role_<?= $role['id'] ?>"><?= $role['description'] ?></label>
    <?php endforeach;?>
    <input name="user_id" id="user_id" type="hidden" value="<?= _v('user_id')?>" />
    <button type="submit">提交</button>
</form>
