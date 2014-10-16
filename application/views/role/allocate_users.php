<?= render_form_open('role','allocate_users') ?>
<?= render_form_header('allocate_users');?>
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
<?= render_form_hidden('role_id',v('role_id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
