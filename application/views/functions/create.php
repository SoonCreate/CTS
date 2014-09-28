<h1>功能注册</h1>
<form id="function_create" method="post" action="<?= _url('functions','create')?>">
    <label for="function_name">*角色名</label><input name="function_name" id="function_name" type="text"/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"></textarea>
    <label for="controller">*控制器</label><input name="controller" id="controller" type="text"/>
    <label for="action">*函数</label><input name="action" id="action" type="text"/>
    <button type="submit">提交</button>
</form>

