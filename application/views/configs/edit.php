<div class="row paneltitle">
    <h3>配置修改</h3>
</div>
<div class="container-fluid userd">
    <form id="config_edit" method="post" action="<?= _url('configs','edit')?>">
    <dl class="row dl-horizontal">
    <dt><label for="config_name">*配置名称</label></dt>
    <dd><input name="config_name" id="config_name" type="text" value="<?= _v('config_name')?>" disabled /></dd></dl>
    <dl class="row dl-horizontal">
    <dt><label for="description">*描述</label></dt>
    <dd><input name="description" id="description" type="text" value="<?= _v('description')?>" disabled/></dd></dl>
    <dl class="row dl-horizontal">
    <dt><label for="config_value">*值</label></dt>
    <dd><input name="config_value" id="config_value" type="text" value="<?= _v('config_value')?>"/></dd></dl>
    <dl class="row dl-horizontal">
    <dt>&nbsp;<input name="id" id="id" type="hidden" value="<?= v('id')?>"  /></dt>
    <dd><button type="submit">提交</button></dd></dl>
    </form>
</div>