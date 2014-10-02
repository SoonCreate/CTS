<h1>需要填写本次内容修改的原因</h1>
<form id="change_reason" method="post" action="<?= _url('order','change_reason')?>">
    <label for="reason">*原因</label>
    <textarea id="reason" name="reason" cols="40" rows="4"></textarea>
    <br/>

    <input name="change_hash" id="change_hash" type="hidden" value="<?= v('change_hash')?>" />
    <button type="submit">提交</button>
</form>

