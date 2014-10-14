<div class="row paneltitle">
    <h3>用户信息更新</h3>
</div>
<form id="user_edit" method="post" action="<?= _url('user',_v('to'))?>">
<div class="container-fluid userd">
    <dl class="row dl-horizontal">
        <dt><label for="username">*用户名</label></dt>
        <dd>
            <input name="username" id="username" type="text" value="<?= _v('username')?>"  data-dojo-type="sckj/form/TextBox" disabled/>
            <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
        </dd>
    </dl>
    <?php $this->load->view('user/_form') ;?>

</div>

<div class="row panelbottom">
        <button type="submit" data-dojo-type="sckj/form/Button" class="success">提交</button>
</div>
</form>
