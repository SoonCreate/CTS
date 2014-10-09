<h1>值集项面新建</h1>
<form id="item_create" method="post" action="<?= _url('valuelist','item_create')?>">
    <label for="segment">*段</label>
    <input name="segment" id="segment" type="text" /><br/>

    <label for="segment">*段值</label>
    <input name="segment" id="segment" type="text" /><br/>

    <label for="segment">*段描述</label>
    <input name="segment" id="segment" type="text" /><br/>

    <label for="segment">*排序码</label>
    <input name="segment" id="segment" type="text" value="0" /><br/>

    <label for="segment">*排序码</label>
    <input name="segment" id="segment" type="text" value="0" /><br/>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <input name="parent_segment" id="parent_segment" type="hidden" value="<?= v('parent_segment')?>" />
    <button type="submit">提交</button>
</form>