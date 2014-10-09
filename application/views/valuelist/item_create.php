<h1>值集项面新建</h1>
<form id="item_create" method="post" action="<?= _url('valuelist','item_create')?>">
    <label for="segment">*段</label>
    <input name="segment" id="segment" type="text" value="<?= _v('default_segment')?>" /><br/>

    <label for="segment_value">*段值</label>
    <input name="segment_value" id="segment_value" type="text" /><br/>

    <label for="segment_desc">*段描述</label>
    <input name="segment_desc" id="segment_desc" type="text" /><br/>

    <label for="sort">*排序码</label>
    <input name="sort" id="sort" type="text" value="0" /><br/>

    <label for="inactive_flag">失效标识</label>
    <input name="inactive_flag" id="inactive_flag" type="checkbox" value="1" /><br/>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <input name="parent_segment" id="parent_segment" type="hidden" value="<?= v('parent_segment')?>" />
    <button type="submit">提交</button>
</form>