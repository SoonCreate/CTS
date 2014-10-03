<h1>会议修改</h1>
<form id="meeting_edit" method="post" action="<?= _url('order_meeting','edit')?>">
    <?php $this->load->view('order_meeting/_form');?>
    <input type="hidden" name="id" value="<?= _v('id')?>">
    <button type="submit">提交</button>
</form>

