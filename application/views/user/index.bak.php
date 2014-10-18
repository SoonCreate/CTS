<table class="table">
    <thead>
        <th>User_id</th>
        <th>用户名</th>
        <th>EMAIL</th>
        <th>联系人</th>
        <th>性别</th>
        <th>手机号码</th>
        <th>固定电话</th>
        <th>公司名称/员工名称</th>
        <th>地址</th>
        <th>通过邮件接收消息</th>
        <th>由管理员初始化密码</th>
        <th>是否失效</th>
        <th>操作</th>
    </thead>
    <?php foreach($users as $u):?>
    <tr>
        <td><?= $u['id']?></td>
        <td><?= $u['username']?></td>
        <td><?= $u['email']?></td>
        <td><?= $u['contact']?></td>
        <td><?= get_label('vl_sex',$u['sex'])?></td>
        <td><?= $u['mobile_telephone']?></td>
        <td><?= $u['phone_number']?></td>
        <td><?= $u['full_name']?></td>
        <td><?= $u['address']?></td>
        <td><?= $u['email_flag']?></td>
        <td><?= $u['initial_pass_flag']?></td>
        <td><?= $u['inactive_flag']?></td>
        <td><a href="<?= _url('user','admin_edit',array('user_id'=>$u['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('user','initial_password',array('user_id'=>$u['id']))?>">密码初始化</a>&nbsp;|&nbsp;
            <?php if($u['inactive_flag'] == 'NO'):?>
                <a href="<?= _url('user','change_status',array('user_id'=>$u['id'],'inactive_flag'=>1))?>">失效</a>
            <?php else : ?>
                <a href="<?= _url('user','change_status',array('user_id'=>$u['id'],'inactive_flag'=>0))?>">生效</a>
            <?php endif; ?>
            &nbsp;|&nbsp;
            <a href="<?= _url('user','choose_roles',array('user_id'=>$u['id']))?>">分配角色</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('user','create')?>">新建用户</a>
<?php if(_config('allow_register')) :?>
    |<a href="<?= _url('user','register')?>">用户注册</a>
<?php endif ;?>