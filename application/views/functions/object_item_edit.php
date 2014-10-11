<h1>权限对象项目修改</h1>
<form id="item_edit" method="post" action="<?= _url('functions','object_item_edit')?>">
    <label for="auth_item_name">*项目名</label>
    <input name="auth_item_name" id="auth_item_name" type="text" value="<?= _v('auth_item_name')?>" disabled/><br/>
    <label for="auth_item_desc">*描述</label>
    <input name="auth_item_desc" id="auth_item_desc" type="text" value="<?= _v('auth_item_desc')?>" disabled/><br/>
    <label for="default_value">*默认值</label>
    <select name="default_value" id="default_value">
        <?= render_options_with_value(_v('auth_item_name'),null,_v('default_value'),TRUE)?>
    </select>
    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <button type="submit">提交</button>
</form>
