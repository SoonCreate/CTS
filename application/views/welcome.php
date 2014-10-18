<!DOCTYPE html>
<html>
<?php $this->load->view('_header') ?>
<body class="sc">
<!--<div id="preloader">Loading Application...</div>-->

<div data-dojo-type="dijit/layout/BorderContainer" id="mainContainer"
     data-dojo-props="gutters:false">
    <div data-dojo-type="dijit/layout/ContentPane" id="headerPane"
         data-dojo-props="splitter:false, region:'top'">
        <div class="comlogo"><img src="<?= base_url() ?>resources/images/sclogo.png" style="height: 50px"/></div>
        <!--div class="headerline"></div-->

    </div>
    <div data-dojo-type="dijit/layout/BorderContainer" id="mainSplitter"
         data-dojo-props="liveSplitters: false, design: 'sidebar', region: 'center'">

        <div data-dojo-type="dijit/layout/TabContainer" id="mainTabContainer"
             data-dojo-props="region: 'center',tabPosition:'left-h',persist:true,tabStrip:true" class=" "><!--,persist:true-->

            <?php if(isset($modules)):?>
            <?php  foreach($modules as $m) :?>
                    <div data-dojo-type="dojox/layout/ContentPane" id="<?= 'module_'. $m['module_id']?>"
                         title="<?= $m['module_desc']?>"
                         iconClass="<?= $m['module_display_class'] ? $m['module_display_class'] : 'icon-globe'?> icon-3x"
                         data-dojo-props=" href:'<?= $m['url']?>'"
                         onDownloadEnd = "refresh_env();"></div>
             <?php  endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>
<div data-dojo-type="dojox/widget/Toaster" data-dojo-props="positionDirection:'tr-left'"
     id="toaster">
</div>
<div class="fixnavbar">
    <ul>
            <li>
                <?= render_link(array('user','notices'),'
                <i class="icon-envelope icon-1x"></i><span class="text">未读消息</span>
                <span class="scbadge" id="scbadge">'._v('notice_need_to_read').'</span>')?>
            </li>
            <li><i class=" icon-off icon-1x"></i><span class="text">退出登录</span></li>
        </ul>
</div>
</body>
</html>