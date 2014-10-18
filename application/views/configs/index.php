<table class="table">
    <thead>
        <th>配置名称</th>
        <th>描述</th>
        <th>值</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['config_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['config_value']?></td>
        <td>
            <?php if($o['editable_flag']):?>
            <a href="<?= _url('configs','edit',array('id'=>$o['id']))?>">编辑</a>
            <?php endif;?>
        </td>

    </tr>
    <?php endforeach;?>
</table>