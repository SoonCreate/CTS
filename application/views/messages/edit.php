<h1>消息修改</h1>
<form id="message_edit" method="post" action="<?= _url('messages','edit')?>">
    <label for="message_code">*消息码</label>
    <input name="message_code" id="message_code" type="text" value="<?= _v('message_code')?>" disabled /><br/>
    <label for="content">*消息内容</label>
    <input name="content" id="content" type="text" value="<?= _v('content')?>" /><br/>

    <label for="language">*语言环境</label>
    <input name="language" id="language" type="text" value="<?=  _v('language')?>" /><br/>

    <label for="help">帮助文档</label>
    <textarea name="help" id="help"><?= _v('help')?></textarea>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>"  />
    <button type="submit">提交</button>
</form>