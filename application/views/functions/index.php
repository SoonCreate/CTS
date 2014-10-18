<table class="table">
    <thead>
        <th>function_id</th>
        <th>功能名</th>
        <th>描述</th>
        <th>控制器</th>
        <th>函数</th>
        <th>是否前端显示</th>
        <th>显示样式</th>
        <th>操作</th>
    </thead>
    <?php foreach($functions as $fn):?>
    <tr>
        <td><?= $fn['id']?></td>
        <td><?= $fn['function_name']?></td>
        <td><?= $fn['description']?></td>
        <td><?= $fn['controller']?></td>
        <td><?= $fn['action']?></td>
        <td><?= $fn['display_flag']?></td>
        <td><?= $fn['display_class']?></td>

        <td><?= render_link(array('functions','edit',array('id'=>$fn['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('functions','destroy',array('id'=>$fn['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('functions','allocate_modules',array('id'=>$fn['id'])),label('allocate_modules'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('functions','objects',array('id'=>$fn['id'])),label('objects'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<div class="row">
    <button data-dojo-type="sckj/form/Button" ><?= render_link(array('functions','create'),label('function_create'))?></button>
</div>