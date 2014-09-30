<h1>用户信息更新</h1>
<form id="user_edit" method="post" action="<?= _url('user',_v('to'))?>">
    <label for="username">*用户名</label>
    <input name="username" id="username" type="text" value="<?= _v('username')?>" disabled/><br/>
    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <?php $this->load->view('user/_form') ;?>
    <button type="submit">提交</button>
</form>
