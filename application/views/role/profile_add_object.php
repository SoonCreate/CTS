<form id="profile_add_object" method="post" action="<?= _url('role','profile_add_object')?>">
    <label for="object_id">*请选择权限对象</label>
    <select id="object_id" name="object_id">
        <?php foreach($objects as $o) :?>
            <option value="<?= $o['id']?>"><?= $o['object_name'].' - '.$o['description']?></option>
        <?php endforeach;?>
    </select>
    <input name="role_id" id="role_id" type="hidden" value="<?= v('role_id')?>" />
    <button type="submit">提交</button>
</form>
