<h1>功能编辑</h1>
<form id="function_edit" method="post" action="<?= _url('functions','edit')?>">
    <label for="function_name">*功能名</label>
    <input name="function_name" id="function_name" type="text" value="<?= _v('function_name')?>" disabled/><br/>

    <label for="controller">*控制器</label><input name="controller" id="controller" type="text" value="<?= _v('controller')?>"/><br/>
    <label for="action">*函数</label><input name="action" id="action" type="text" value="<?= _v('action')?>"/><br/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"><?= _v('description')?></textarea><br/>
    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <button type="submit">提交</button>
</form>

