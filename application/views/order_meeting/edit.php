<?= render_form_header('meeting_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('order_meeting','edit') ?>
    <?php $this->load->view('order_meeting/_form');?>
    <?= render_form_hidden('id',_v('id'))?>
    <?= render_form_close() ?>
</div>

