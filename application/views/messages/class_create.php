<h1>消息类创建</h1>
<form id="class_create" method="post" action="<?= _url('messages','class_create')?>">
    <label for="class_code">*消息类名</label>
    <input name="class_code" id="class_code" type="text"  /><br/>
    <label for="description">*类描述</label>
    <input name="description" id="description" type="text"  /><br/>

    <button type="submit">提交</button>
</form>