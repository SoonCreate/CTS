<script type="text/javascript">
    <?php if(_sess('cm')) :?>
    $env.cm = <?= _sess('cm')?>;
    <?php endif; ?>
    <?php if(_sess('fid')) :?>
    $env.fid = <?= _sess('fid')?>;
    <?php endif; ?>
</script>
<!--<div class="fixtop">-->
<!--        <a href="#" onclick="menu()">菜单选择</a>-->
<!--        &nbsp;|&nbsp;<a href="#" onclick="goback()">返回</a>-->
<!--        &nbsp;|&nbsp;<a href="#" onclick="refresh()">刷新</a>-->
<!--</div>-->

<div id="toolbar" data-dojo-type="sckj/Toolbar" class="fixtop">
<!--    <div data-dojo-type="dijit/form/Button" id="toolbar1.cut"-->
<!--         data-dojo-props="iconClass:'dijitEditorIcon dijitEditorIconCut', showLabel:false">Cut</div>-->
<!--    --><?//= render_button('menu','menu()') ?>
    <button type="button" data-dojo-type="sckj/form/Button"
            id = "wsoGoBack"
            iconClass="icon-reply icon-large"
            onclick="goback()"
            showLabel = "false"
            title="<?= label('back')?>"></button>
    <?= render_icon_button('icon-refresh icon-large','refresh','refresh()')?>
    <!-- 功能标题 -->
    <div style="float: right;
    margin-right: 15px;
    font-size: large;
    -webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;" ><?= _sess('wso_title')?></div>
</div>

<div class="formalert row" id="<?= _sess('cm')?>_formalert" style="display: none">
    <button type="button" class="close" data-dismiss="alert" onclick="formAlertclose(<?= _sess('cm')?>)" id="closebtn">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <ul></ul>
</div>
<?php echo  $content_for_layout ?>