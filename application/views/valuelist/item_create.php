<h1>值集项目新建</h1>
<form id="item_create" method="post" action="<?= _url('valuelist','item_create')?>">
    <?php $this->load->view('valuelist/_item_form');?>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <input name="parent_segment" id="parent_segment" type="hidden" value="<?= v('parent_segment')?>" />
    <button type="submit">提交</button>
</form>