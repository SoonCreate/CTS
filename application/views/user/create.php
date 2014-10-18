<div class="row paneltitle">
    <h3>用户创建</h3>
</div>
<div class="container-fluid userd">
    <form id="user_create" method="post" action="<?= _url('user','create')?>">
    <dl class="row dl-horizontal">
    <dt><label for="username">*用户名</label></dt><dd><input name="username" id="username" type="text"/></dd></dl>
    <?php $this->load->view('user/_form') ;?>
    <dl class="row dl-horizontal">
        <dt>&nbsp;</dt><dd><button type="submit">提交</button></dd></dl>
    </form>
</div>

