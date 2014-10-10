<h1>消息类更改</h1>
<form id="class_edit" method="post" action="<?= _url('messages','class_edit')?>">
    <label for="class_code">*消息类名</label>
    <input name="class_code" id="class_code" type="text" value="<?= _v('class_code')?>" disabled  /><br/>
    <label for="description">*类描述</label>
    <input name="description" id="description" type="text"  value="<?= _v('description')?>" /><br/>
    <input name="id" id="id" type="hidden"  value="<?= v('id')?>" />
    <button type="submit">提交</button>
</form>