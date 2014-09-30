<h1>模块创建</h1>
<form id="module_create" method="post" action="<?= _url('modules','create')?>">
    <label for="module_name">*模块名</label><input name="module_name" id="module_name" type="text" /><br/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"></textarea><br/>
    <label for="sort">*排序码</label><input name="sort" id="sort" type="text" value="0"/><br/>
    <button type="submit">提交</button>
</form>

