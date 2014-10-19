<script type="text/javascript">
    $env.cm = <?= _sess('cm')?>;
    $env.fid = <?= _sess('fid')?>;
</script>
<div class="fixtop">
        <a href="#" onclick="menu()">菜单选择</a>
        &nbsp;|&nbsp;<a href="#" onclick="goback()">返回</a>
        &nbsp;|&nbsp;<a href="#" onclick="refresh()">刷新</a>
</div>
<div class="formalert row" id="<?= _sess('cm')?>_formalert" style="display: none">
    <button type="button" class="close" data-dismiss="alert" onclick="formAlertclose(<?= _sess('cm')?>)" id="closebtn">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <ul></ul>
</div>
<?php echo  $content_for_layout ?>