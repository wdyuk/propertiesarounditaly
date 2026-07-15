<?php
	
	require 'init.php';

	$id = (int)$_REQUEST['id'];
	$type = $_REQUEST['type'];
	$table = $_REQUEST['table'];
	//$path_to_folder = BASE_DIR."media/".$_REQUEST['folder_path'];
	$path_to_folder = BASE_DIR."uploads/vehicles/";
	$where = sprintf('id = %d AND media_type = "%s"', $id, $type);
	
	$medias =table_fetch_rows($table, $where, 'position ASC'); 
	$mediaDIR = $path_to_folder;


	foreach ($medias as $media){
	if (file_exists($mediaDIR . '/' .$media['filename']))
		{
			$parts = explode(".", $media['filename']);
			$name = $parts[0];

			unlink($mediaDIR . '' .$media['filename']);
			unlink($mediaDIR . '' .$name.'_thumb.'.$parts[1]);
			unlink($mediaDIR . '' .$name.'_web.'.$parts[1]);
		}	
	}
	
	table_delete_row($table, $where);
	
?>
