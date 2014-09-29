<h1>模块信息修改</h1>
<form id="module_edit" method="post" action="<?= _url('modules','edit')?>">
    <label for="module_name">*模块名</label><input name="module_name" id="module_name" type="text" value="<?= _v('module_name')?>" disabled/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"><?= _v('description')?></textarea>
    <label for="sort">*排序码</label><input name="sort" id="sort" type="text" value="<?= _v('sort')?>"/>
    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <button type="submit">提交</button>
</form>
