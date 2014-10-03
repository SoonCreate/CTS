<h1>会议取消</h1>
<form id="meeting_cancel" method="post" action="<?= _url('order_meeting','cancel')?>">
    <label for="cancel_reason">取消原因：</label>
    <select name="cancel_reason" id="cancel_reason">
        <?= render_options('vl_meeting_cancel')?>
    </select>
    <br/>
    <label for="cancel_remark">备注</label>
    <textarea name="cancel_remark" id="cancel_remark"></textarea>
    <input type="hidden" name="id" value="<?= _v('id')?>">
    <button type="submit">提交</button>
</form>

