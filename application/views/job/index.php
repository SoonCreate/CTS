<table class="table">
    <thead>
    <th><?= label('job_name')?></th>
    <th><?= label('description')?></th>
    <th><?= label('output_type')?></th>
    <th><?= label('period_flag')?></th>
    <th><?= label('first_exec_date')?></th>
    <th><?= label('next_exec_date')?></th>
    <th><?= label('created_by')?></th>
    <th><?= label('creation_date')?></th>
    <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['job_name']?></td>
            <td><?= $o['description']?></td>
            <td><?= $o['output_type']?></td>
            <td><?= $o['period_flag']?></td>
            <td><?= $o['first_exec_date']?></td>
            <td><?= $o['next_exec_date']?></td>
            <td><?= $o['created_by']?></td>
            <td><?= $o['creation_date']?></td>
            <td>
                <?= render_link(array('job','edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('job','steps',array('id'=>$o['id'])),label('step'),null,null,true)?>
                &nbsp;|&nbsp;
                <?= render_link(array('job','histories',array('id'=>$o['id'])),label('history'))?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('job_create') ?>",url('job/create'));
</script>