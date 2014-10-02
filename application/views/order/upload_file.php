<form id="upload_file" encType="multipart/form-data" action="<?= _url('order','upload_file')?>" method="post">

    <label for="file">*文件</label>
    <input type="file" id="file" name="userfile" size="20"/>
    <input type="submit" value="upload" />
</form>