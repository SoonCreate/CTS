<?= render_form_header('file_upload')?>
<form id="upload_file"  encType="multipart/form-data" action="<?= _url('order_meeting','upload_file')?>" method="post">
<dl class="row dl-horizontal"><dt> <label for="file">*文件</label></dt>
<dd><input type="file" id="file" name="userfile" size="20"/></dd></dl>
<?= render_form_input('description',true)?>
<?= render_form_hidden('id',v('id'))?>
<?= render_button_group()?>
</form>