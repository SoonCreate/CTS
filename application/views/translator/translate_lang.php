<?php

echo render_form_open('translator','index');


foreach($hidden as $key=>$value){
    echo render_form_hidden($key,$value);
}

?>

<table class="table">

<?php

echo '<tr>';
echo '<td class="translator_table_header">' . 'Key' . '</td>';
echo '<td class="translator_table_header">' . ucwords( $masterLang ) . '</td>';
echo '<td class="translator_table_header">' . ucwords( $slaveLang ) . '</td>';
echo '</tr>';

foreach ( $moduleData as $key => $line ) {
	echo '<tr valign="top">';
	echo '<td width="20%">' . $key . '</td>';
	echo '<td width="40%">' . htmlspecialchars( $line[ 'master' ] ) . '</td>';
	
	if ( mb_strlen( $line[ 'slave' ] ) > $textarea_line_break ) {
		echo '<td><textarea name="'.$postUniquifier . $key.'"  data-dojo-type="sckj/form/Textarea" >'.$line[ 'slave' ].'</textarea>';
	} else {
		echo '<td><input data-dojo-type="sckj/form/TextBox" trim="true" name="'.$postUniquifier . $key.'"  value="'.htmlspecialchars( $line[ 'master' ] ).'" />';
	}

	if ( strlen( $line[ 'error' ] ) > 0 ) {
		echo '<br /><span class="translator_error">' . $line[ 'error' ] . '</span>';
	}

	if ( strlen( $line[ 'note' ] ) > 0 ) {
		echo '<br /><span class="translator_note">' . $line[ 'note' ] . '</span>';
	}

	echo '</td>';
	echo '</tr>';
}

?>

</table>
<br/>


<?php

echo render_form_hidden('ConfirmSaveLang','Confirm');
echo render_button_group();

echo render_form_close();
	
?>