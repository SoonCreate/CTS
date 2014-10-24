<?= render_form_open('order_meeting','choose_orders') ?>
    <table class="table">
        <thead>
        <th>选择</th>
        <th>订单号</th>
        <th>标题</th>
        <th>内容概要</th>
        <th>投诉人</th>
        <th>创建时间</th>
        </thead>
        <?php foreach($objects as $o) :?>
            <tr>

            </tr>
        <?php endforeach;?>
    </table>
<?= render_button_group();?>
<?= render_form_close() ?>