<h1>会议创建</h1>
<form id="meeting_create" method="post" action="<?= _url('order_meeting','create')?>">
    <?php $this->load->view('order_meeting/_form');?>
    <button type="submit">提交</button>
</form>

