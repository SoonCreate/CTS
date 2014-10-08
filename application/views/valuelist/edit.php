<h1>值集修改</h1>
<form id="valuelist_edit" method="post" action="<?= _url('valuelist','edit')?>">
    <label for="valuelist_name">*值集名称</label>
    <input name="valuelist_name" id="valuelist_name" type="text" value="<?= _v('valuelist_name')?>" disabled/><br/>
    <?php $this->load->view('valuelist/_form');?>
    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <button type="submit">提交</button>
</form>
