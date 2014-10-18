<table class="table">
    <thead>
        <th>module_id</th>
        <th>模块名</th>
        <th>描述</th>
        <th>排序码</th>
        <th>操作</th>
    </thead>
    <?php foreach($modules as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['module_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['sort']?></td>

        <td>
            <?= render_link(array('modules','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('modules','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('modules','choose_functions',array('module_id'=>$o['id'])),label('choose_functions'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<div class="row">
    <button data-dojo-type="sckj/form/Button" ><?= render_link(array('modules','create'),label('module_create'))?></button>
</div>