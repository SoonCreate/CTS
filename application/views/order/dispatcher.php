<h1>投诉订单创建</h1>
<form id="order_dispatcher" method="post" action="<?= _url('order','dispatcher')?>">

    <label for="manager_id">*负责人</label>
    <select id="manager_id" name="manager_id">
        <?php foreach($ids as $id):?>
        <option value="<?= $id?>" <?php if(_v('manager_id') === $id) : echo 'selected' ; endif;?>><?= full_name($id)?></option>
        <?php endforeach;?>
    </select>
    <br/>

    <label for="plan_complete_date">*计划完成时间</label>
    <input name="plan_complete_date" id="plan_complete_date" type="text" value="<?=_v('plan_complete_date') ?>" />
    <br/>

    <input name="id" id="id" type="hidden" value="<?= p('id') ?>"/>
    <button type="submit">提交</button><a href="<?= _url('order','meeting_create',array('id'=>p('id')))?>">召开会议</a>
</form>

