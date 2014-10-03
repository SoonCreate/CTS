<form id="upload_file" encType="multipart/form-data" action="<?= _url('order_meeting','upload_file')?>" method="post">

    <label for="file">*文件</label>
    <input type="file" id="file" name="userfile" size="20"/>
    <label for="description">*说明</label>
    <input type="text" name="description" id="description"/>
    <input type="hidden" name="id" id="id" value="<?= _v('id')?>"/>
    <input type="submit" value="upload" />
</form>