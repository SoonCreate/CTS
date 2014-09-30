<h1>投诉订单创建</h1>
<form id="order_create" method="post" action="<?= _url('order','create')?>">
    <label for="severity">*严重性</label>
    <select name="severity" id="severity">
        <?= render_options('vl_severity')?>
    </select>
    <br/>

    <label for="frequency">*发生频率</label>
    <select name="frequency" id="frequency">
        <?= render_options('vl_frequency')?>
    </select>
    <br/>

    <?php if(isset($categories)) :?>
    <label for="category">*分类</label>
    <select name="category" id="category">
    <?php foreach($categories as $c):?>
            <option value="<?= $c?>"><?= get_label('vl_order_category',$c,$order_type)?></option>
    <?php endforeach;?>
     </select>
    <?php endif; ?>
    <br/>

    <label for="title">*标题</label>
    <input name="title" id="title" type="text" />
    <br/>

    <label for="content">*内容</label>
    <textarea id="content" name="content" cols="40" rows="4"></textarea>
    <br/>

<hr/>
    <label for="contact">*本次投诉联系人</label>
    <input name="contact" id="contact" type="text" />
    <br/>

    <label for="mobile_telephone">*手机号码</label>
    <input name="mobile_telephone" id="mobile_telephone" type="text" />填写手机号码，如果“自己”之前有填写过，则自动带出相关信息
    <br/>

    <label for="phone_number">公司电话</label>
    <input name="phone_number" id="phone_number" type="text" />
    <br/>

    <label for="full_name">公司名称</label>
    <input name="full_name" id="full_name" type="text" />
    <br/>

    <label for="address">公司地址</label>
    <input name="address" id="address" type="text" />
    <br/>


    <input name="order_type" id="order_type" type="hidden" value="<?= $order_type ?>"/>
    <button type="submit">提交</button>
</form>

