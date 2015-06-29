<?= render_form_header('po_header') ?>
<?php if(isset($PO_HEADER)){?>
    <div class="container-fluid userd">
        <dl class="row dl-horizontal">
            <dt><label>供应商编号</label></dt>
            <dd><?= $PO_HEADER['VENDOR'] ?></dd>
            <dt><label>供应商名称</label></dt>
            <dd><?= $PO_HEADER['VEND_NAME'] ?></dd>
        </dl>
        <dl class="row dl-horizontal">
            <dt><label>订单号</label></dt>
            <dd><?= $PO_HEADER['PO_NUMBER'] ?></dd>
        </dl>
    </div>
    <table class="container-fluid userd">
        <tr class="row dl-horizontal">
            <td><label>供应商编号</label></td>
            <td><?= $PO_HEADER['VENDOR'] ?></td>
            <td><label>供应商名称</label></td>
            <td><?= $PO_HEADER['VEND_NAME'] ?></td>
        </tr>
        <tr class="row dl-horizontal">
            <td><label>订单号</label></td>
            <td><?= $PO_HEADER['PO_NUMBER'] ?></td>
        </tr>
    </table>
<?php }?>