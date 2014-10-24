<?= render_form_header('meeting_create');?>
<div class="container-fluid userd">
    <?= render_form_open('order_meeting','create') ?>
    <?php $this->load->view('order_meeting/_form');?>
    <?= render_form_close() ?>
</div>
