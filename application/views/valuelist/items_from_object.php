<table>
    <thead>
        <th>段值</th>
        <th>段描述</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['value']?></td>
        <td><?= $o['label']?></td>
    </tr>
    <?php endforeach;?>
</table>