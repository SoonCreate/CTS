<script type="text/javascript">
    $env.cm = <?= _sess('cm')?>;
    $env.fid = <?= _sess('fid')?>;
</script>
<!--<div class="fixtop">-->
<!--        <a href="#" onclick="menu()">菜单选择</a>-->
<!--        &nbsp;|&nbsp;<a href="#" onclick="goback()">返回</a>-->
<!--        &nbsp;|&nbsp;<a href="#" onclick="refresh()">刷新</a>-->
<!--</div>-->

<div id="toolbar" data-dojo-type="sckj/Toolbar" class="fixtop">
<!--    <div data-dojo-type="dijit/form/Button" id="toolbar1.cut"-->
<!--         data-dojo-props="iconClass:'dijitEditorIcon dijitEditorIconCut', showLabel:false">Cut</div>-->
    <?= render_button('menu','menu()') ?>
    <span data-dojo-type="dijit/ToolbarSeparator"></span>
    <?= render_button('back','goback()') ?>
    <span data-dojo-type="dijit/ToolbarSeparator"></span>
    <?= render_button('refresh','refresh()') ?>
</div>

<div class="formalert row" id="<?= _sess('cm')?>_formalert" style="display: none">
    <button type="button" class="close" data-dismiss="alert" onclick="formAlertclose(<?= _sess('cm')?>)" id="closebtn">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <ul></ul>
</div>
<?php echo  $content_for_layout ?>