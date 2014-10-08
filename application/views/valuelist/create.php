<h1>值集创建</h1>
<form id="valuelist_create" method="post" action="<?= _url('valuelist','create')?>">
    <label for="valuelist_name">*值集名称</label>
    <input name="valuelist_name" id="valuelist_name" type="text"/><br/>
    <?php $this->load->view('valuelist/_form');?>
    <button type="submit">提交</button>
</form>
