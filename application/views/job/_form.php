<?= render_form_input('job_name',true)?>
<?= render_form_input('description',true)?>
<?= render_select_with_options('output_type','vl_output_type',true)?>
<?= render_single_checkbox('period_flag',1)?>
<input data-dojo-type="sckj/form/DateTimeTextBox" name="first_exec_date"/>