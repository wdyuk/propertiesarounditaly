<?php
	
	$messages = array();
	if (isset($_POST['save'])) {
		$fields = array('title', 'description', 'date');
		$_POST['date'] = convert_date($_POST['date']);
		table_insert(TBL_PHOTOGALLERY, $fields, $_POST);
		
		$messages[] = 'Saved successfully.';
	}
	
?>
<form class="validate-form" method="post">
<table>
<tr>
	<td colspan="2"><h1>Add Gallery</h1></td>
</tr>
<tr>
    <td colspan="2"><?php show_messages($messages); ?></td>
</tr>
<tr>
	<td>Title:</td>
    <td><input class="required" name="title" id="title" size="40" type="text" value="" /></td>
</tr>
<tr>
	<td>Description:</td>
    <td><input class="required" name="description" id="description" size="100" type="text" value="" /></td>
</tr>
<tr>
	<td>Date:</td>
    <td><input class="required datepicker" name="date" id="date" size="10" type="text" value="<?php echo date('d/m/Y'); ?>" /></td>
</tr>
<tr>
	<td></td>
    <td><?php show_big_button('save', 'Save'); ?></td>
</tr>
</table>
</form>