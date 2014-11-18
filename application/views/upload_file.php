<form id="upload_file" encType="multipart/form-data" action="<?= _url('order','upload_file')?>" method="post">
    <label for="file">*<?= label('file')?></label>
    <input type="file" id="file" name="userfile" size="20"/>
    <br/>
    <label for="description"><?= label('description')?></label>
    <input type="text" data-dojo-type="sckj/form/TextBox" name="description"/>
    <?= render_form_hidden('id')?>
</form>