<table class="table">
    <thead>
    <th><?= label('step')?></th>
    <th><?= label('function_name')?></th>
    <th><?= label('function_desc')?></th>
    <th><?= label('variant_name')?></th>
    <th><?= label('variant_desc')?></th>
    <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['step']?></td>
            <td><?= $o['function_name']?></td>
            <td><?= $o['function_desc']?></td>
            <td><?= $o['variant_name']?></td>
            <td><?= $o['variant_desc']?></td>
            <td>
                <?= render_link(array('job','step_edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('job','step_destroy',array('id'=>$o['id'])),label('destroy'))?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('step_create') ?>",url('job/step_create?job_id=<?= _v('job_id')?>'));
</script>