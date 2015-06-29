<?= render_form_header('po_header') ?>
<?php if(isset($PO_HEADER)){?>

    <table>
        <tr>
            <td>
                <div class="container-fluid userd">
                    <dl class="row dl-horizontal">
                        <dt>订单号</dt>
                        <dd><?= $PO_HEADER['PO_NUMBER'] ?></dd>
                    </dl>
                    <dl class="row dl-horizontal">
                        <dt>供应商编号</dt>
                        <dd><?= clear_prezero($PO_HEADER['VENDOR'])?></dd>
                    </dl>
                </div>
            </td>
            <td>
                <div class="container-fluid userd">
                    <dl class="row dl-horizontal">
                        <dt>状态</dt>
                        <dd></dd>
                    </dl>
                    <dl class="row dl-horizontal">
                        <dt>供应商名称</dt>
                        <dd><?= $PO_HEADER['VEND_NAME'] ?></dd>
                    </dl>
                </div>
            </td>
        </tr>
    </table>
<?php }?>

<?= render_form_header('po_lines') ?>
<?php if(isset($PO_ITEMS) && !empty($PO_ITEMS)){?>
    <table class="table">
        <tr>
            <th>项目</th>
            <th>删除标识</th>
            <th>物料编码</th>
            <th>物料描述</th>
            <th>工厂</th>
            <th>需求数量</th>
            <th>单位</th>
        </tr>
<?php foreach($PO_ITEMS as $l){
    echo '<tr>';
    echo '<td>'.$l['PO_ITEM'].'</td>';
    echo '<td>'.$l['DELETE_IND'].'</td>';
    echo '<td>'.clear_prezero($l['MATERIAL']).'</td>';
    echo '<td>'.$l['SHORT_TEXT'].'</td>';
    echo '<td>'.$l['PLANT'].'</td>';
    echo '<td>'.$l['QUANTITY'].'</td>';
    echo '<td>'.$l['UNIT'].'</td>';
    echo '</tr>';
}?>
    </table>

<?php }?>