<?= render_form_header('user_information_edit')?>
<div class="container-fluid userd">
    <?= render_form_open('user',_v('to'))?>
    <?= render_form_input('username',false,true)?>
    <?php $this->load->view('user/_form') ;?>
    <?= render_form_hidden('id')?>
    <?= render_button_group()?>
    <?= render_form_close() ?>
</div>
<?php if(_v('to') == 'user_edit'){?>
    <script type="text/javascript">
        toolBarAddLinkButton("<?= label('change_password') ?>",url('user/change_password'));
        toolBarAddLinkButton("<?= label('user_configs') ?>",url('user/configs'));
    </script>
<?php }?>