<h1>配置修改</h1>
<form id="config_edit" method="post" action="<?= _url('configs','edit')?>">
    <label for="config_name">*配置名称</label>
    <input name="config_name" id="config_name" type="text" value="<?= _v('config_name')?>" disabled /><br/>
    <label for="description">*描述</label>
    <input name="description" id="description" type="text" value="<?= _v('description')?>" disabled/><br/>

    <label for="config_value">*值</label>
    <input name="config_value" id="config_value" type="text" value="<?= _v('config_value')?>"/><br/>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>"  />
    <button type="submit">提交</button>
</form>