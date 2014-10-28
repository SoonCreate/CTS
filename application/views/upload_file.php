<form id="upload_file" encType="multipart/form-data" action="<?= _url('order','upload_file')?>" method="post">
    <label for="file">*文件</label>
    <input type="file" id="file" name="userfile" size="20"/>
    <br/>
    <label for="description">描述</label>
    <input type="text" data-dojo-type="sckj/form/TextBox" name="description"/>
    <?= render_form_hidden('id')?>
</form>