<h1>用户选择</h1>
<form id="allocate_users" method="post" action="<?= _url('role','allocate_users')?>">
    <table>
        <thead>
            <th>选择</th>
            <th>用户名</th>
            <th>公司名称/员工名称</th>
            <th>注册时间</th>
        </thead>
        <?php foreach($users as $user) :?>
            <tr>
                <td><input type="checkbox" name="users[]" id="user_<?= $user['id'] ?>" value="<?= $user['id']?>" <?= $user['checked']?>/></td>
                <td><label for="user_<?= $user['id'] ?>"><?= $user['username'] ?></label></td>
                <td><?= $user['full_name']?></td>
                <td><?= $user['creation_date']?></td>
            </tr>
        <?php endforeach;?>
    </table>

    <input name="role_id" id="role_id" type="hidden" value="<?= _v('role_id')?>" />
    <button type="submit">提交</button>
</form>
