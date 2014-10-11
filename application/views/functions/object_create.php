<h1>新增权限对象</h1>
<form id="object_create" method="post" action="<?= _url('functions','object_create')?>">
    <label for="object_id">*请选择权限对象</label>
    <select id="object_id" name="object_id">
        <?php foreach($objects as $o) :?>
            <option value="<?= $o['id']?>"><?= $o['object_name'].' - '.$o['description']?></option>
        <?php endforeach;?>
    </select>
    <input name="function_id" id="function_id" type="hidden" value="<?= v('function_id')?>" />
    <button type="submit">提交</button>
</form>

