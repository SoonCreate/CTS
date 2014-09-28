<h1>用户创建</h1>
<form id="user_create" method="post" action="<?= _url('user','create')?>">
    <label for="username">*用户名</label><input name="username" id="username" type="text"/>
    <?php $this->load->view('user/_form') ;?>
    <button type="submit">提交</button>
</form>

