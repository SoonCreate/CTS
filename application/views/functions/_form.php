<?= render_form_input('controller',true)?>
<?= render_form_input('action',true);?>
<?= render_form_input('description',true)?>
<?= render_single_checkbox('display_flag',1)?>
<?= render_single_checkbox('render_flag',1)?>
<?= render_single_checkbox('blank_flag',1)?>
<?= render_form_input('display_class',false,false,null,null,'<a target="_blank" href="http://www.bootcss.com/p/font-awesome/#icons-new">font-awesome</a>')?>
<?= render_form_textarea('help')?>