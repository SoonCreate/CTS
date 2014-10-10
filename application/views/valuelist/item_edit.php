<h1>值集项目修改</h1>
<form id="item_edit" method="post" action="<?= _url('valuelist','item_edit')?>">
    <?php $this->load->view('valuelist/_item_form');?>
    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <button type="submit">提交</button>
</form>