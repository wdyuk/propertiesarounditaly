<?php
    require '../../application.php';
    
    if(isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])){
        $name = generateRandomString(5);
        $path = $_FILES['file']['name'];
        $gallery_id = $_POST['gallery_id'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $upload_path = 'gallery';

        $filename = $name.'-'.$_FILES['file']['name'];
        
        $path = upload_file($_FILES['file'], $name, $upload_path,true);
        
        if($path){
            $pathfile = 'uploads/gallery/'.$filename;

            $fields = array('filename','gallery_id','created_at');
            
			$ary = array(
                'filename' => $filename,
                'gallery_id'=>$gallery_id,
                'created_at'=>date('Y-m-d h:i:s')
            );
            table_insert('photos', $fields, $ary);
            $messages[] = 'Saved successfully.';
            echo 'success';
        } else {
            echo 'failed';
        }
        exit;
    }
?>