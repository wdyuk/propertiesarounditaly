<?php

	error_reporting(E_ALL);
	ini_set('display_errors','1');
	require('../application.php');
	//use GifCreator\GifCreator;

	$id = (int)$_POST['id'];
	$table = sanitize_sql_string($_POST['table']);

	if(isset($_POST['photo'])) {
		
		foreach($_POST['photo'] as $key => $photo) {
			$fields = array('position');
			$values = array('position' => ($key + 1));
			$where = sprintf('id = %d', $photo);
			table_update($table, $fields, $values, $where);
			if ($key == 0) {
				$mainphoto = table_fetch_row($table,$where);
			}
		}

		$result = array('main_photo_url' => $mainphoto['filename']);

	    echo json_encode($result,true);
		

	}
	
?>