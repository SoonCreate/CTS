<script type="text/javascript">
    $env.cm = <?= _sess('cm')?>;
    $env.mid = <?= _sess('mid')?>;
    $env.fid = <?= _sess('fid')?>;
</script>
<div class="row paneltitle">
    <h3><?php render_link(_url('welcome','my_functions',array('module_id'=>_sess('mid'))),"菜单选择")?></h3>
</div>
<div class="formalert row" id="<?= _sess('cm')?>_formalert" style="display: none">
    <button type="button" class="close" data-dismiss="alert" onclick="formAlertclose(<?= _sess('cm')?>)" id="closebtn">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <ul></ul>
</div>
<?php echo  $content_for_layout ?>