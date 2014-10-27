<div class="row paneltitle">
    <h3>用户信息更新</h3>
</div>
<form id="user_edit" method="post" action="<?= _url('user',_v('to'))?>" onsubmit="return formSubmit(this)">
<div class="container-fluid userd">
    <?php if(_v('to') == 'user_edit'){?>
    <dl class="row dl-horizontal">
        <dt><?= lang('change_password')?></dt>
        <dd>
            <?= render_link_button(array('user','change_password'),label('change_password'))?>
        </dd>
    </dl>
    <?php }?>
    <dl class="row dl-horizontal">
        <dt><label for="username">*用户名</label></dt>
        <dd>
            <input name="username" id="username" type="text" value="<?= _v('username')?>"  data-dojo-type="sckj/form/TextBox" disabled/>
            <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
        </dd>
    </dl>
    <?php $this->load->view('user/_form') ;?>

</div>

<div class="fixbottom"">
        <button type="submit" data-dojo-type="sckj/form/Button" class="success"><i class=" icon-circle-arrow-right"></i><label>提交</label></button>
</div>
</form>
