<h1>权限对象项目创建</h1>
<form id="item_create" method="post" action="<?= _url('auth_object','item_create')?>">
    <label for="valuelist_id">*权限对象值集选择</label>
    <select name="valuelist_id" id="valuelist_id">
        <?= render_options('vl_authobject')?>
    </select>
    <label for="default_value">*默认值</label>
    <input name="default_value" id="default_value" type="text" value="<?= _config('all_values')?>" />
    <input name="object_id" id="object_id" type="hidden" value="<?= v('object_id')?>" />
    <button type="submit">提交</button>
</form>
