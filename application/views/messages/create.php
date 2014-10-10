<h1>消息创建</h1>
<form id="message_create" method="post" action="<?= _url('messages','create')?>">
    <label for="message_code">*消息码</label>
    <input name="message_code" id="message_code" type="text"  /><br/>
    <label for="content">*消息内容</label>
    <input name="content" id="content" type="text"  /><br/>
    <input name="class_id" id="class_id" type="hidden" value="<?= v('class_id')?>"  />
    <button type="submit">提交</button>
</form>