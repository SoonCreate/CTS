<h2>采购订单详情</h2>
<?php if(isset($PO_HEADER)){?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                供应商编号:<?= $PO_HEADER['VENDOR'] ?>
            </div>
            <div class="col-md-4">
                供应商名称:<?= $PO_HEADER['VEND_NAME'] ?>
            </div>
            <div class="col-md-4">
                订单号:<?= $PO_HEADER['PO_NUMBER'] ?>
            </div>
        </div>
    </div>
<?php }?>