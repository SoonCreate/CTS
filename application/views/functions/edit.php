<h1>功能编辑</h1>
<form id="function_edit" method="post" action="<?= _url('functions','edit')?>">
    <label for="function_name">*功能名</label>
    <input name="function_name" id="function_name" type="text" value="<?= _v('function_name')?>" disabled/><br/>

    <label for="controller">*控制器</label><input name="controller" id="controller" type="text" value="<?= _v('controller')?>"/><br/>
    <label for="action">*函数</label><input name="action" id="action" type="text" value="<?= _v('action')?>"/><br/>
    <label for="description">*描述</label><textarea id="description" name="description" rows="5" cols="40"><?= _v('description')?></textarea><br/>
    <label for="display_flag">是否在前台可视</label>

    <input type="checkbox" name="display_flag" id="display_flag" value="1" <?php if(_v('display_flag')):echo 'checked';endif;?>/>
    <br/>
    <label for="display_class">字体图标样式</label>
    <input name="display_class" id="display_class" type="text" value="<?= _v('display_class')?>"/><br/>
    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <button type="submit">提交</button>
</form>

