<h1>功能注册</h1>
<form id="function_create" method="post" action="<?= _url('functions','create')?>">
    <label for="function_name">*功能名</label>
    <input name="function_name" id="function_name" type="text"/><br/>
    <label for="controller">*控制器</label><input name="controller" id="controller" type="text"/><br/>
    <label for="action">*函数</label><input name="action" id="action" type="text"/><br/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"></textarea><br/>
    <button type="submit">提交</button>
</form>

