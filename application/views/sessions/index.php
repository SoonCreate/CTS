<table class="table">
    <thead>
    <th>用户名</th>
    <th>描述</th>
    <th>操作系统</th>
    <th>浏览器</th>
    <th>手机型号</th>
    <th>IP地址</th>
    <th>模块</th>
    <th>功能</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['username']?></td>
            <td><?= $o['full_name']?></td>
            <td><?= $o['platform']?></td>
            <td><?= $o['browser']?></td>
            <td><?= $o['mobile']?></td>
            <td><?= $o['ip_address']?></td>
            <td><?= $o['module_desc']?></td>
            <td><?= $o['function_desc']?></td>
            <td>
                <?= render_link(array('sessions','kill',array('id'=>$o['session_id'])),label('kill_session'),null,null,true)?>
                &nbsp;|&nbsp;
                <?= render_link(array('sessions','push_message',array('id'=>$o['session_id'])),label('push_message'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('user','admin_edit',array('id'=>$o['user_id'])),label('user_information'))?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('kill_all_sessions') ?>",url('sessions/kill_all'),null,true);
</script>