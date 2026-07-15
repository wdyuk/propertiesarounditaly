<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
   

    if(isset($_POST['save']))
    {
        $fields = array('title','about','status');


        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('export_process', $fields, $_POST);
            $messages[] = 'Saved successfully.';
           
        }
        else 
        {
            table_update('export_process', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Saved successfully.';
        }   

        if( isset($_POST['delete']) ){
            foreach($_POST['delete'] as $image) {
                if( file_exists('../' . $image) ) {
                    unlink('../' . $image);
                }
            }
        }
        if( isset($_POST['delete-meta']) ){
            foreach($_POST['delete-meta'] as $image) {
                if( file_exists('../' . $image) ) {
                    unlink('../' . $image);
                }
            }
        }
    	if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {

    		$imgData = pathinfo($_FILES['image']['name']);
    		$image = new AdvancedSimpleImage();
        
    		$image->fromFile($_FILES['image']['tmp_name']);

    		$image->toFile(UPLOADS_DIR . 'export_process/' .$table_id . '-icon.' . $imgData['extension']);
    	}
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('export_process', 'id=' . $table_id); 
    }
    
?>
<div class="row">
    <div class="col-md-12">
        <?php if(!empty($messages)) {
           show_messages($messages);
        };
        if(!empty($errors)) {
           show_errors($errors);
        };
        ?>
    </div>
</div>
<form class="validate-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : 0 ; ?>" />
    <div class="card mb-4">
        <div class="card-header">
            <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Export Process Step</h1>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="image">Image:</label>
                <input size="40" type="file" id="image" name="image" value="" class="form-control"  />
            </div>
            <div class="form-group">
                <?php    
                if($table_id > 0) {  
            	    $path = get_image('export_process/' . $data['id'] . '-icon');

            	    if (strlen($path) > 0):
                        ?>
               
            	        <?php show_image('export_process/' . $data['id'] . '-icon'); ?>
            	        <label><input type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
            	    
                    <?php endif; 
                }?>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input class="required form-control" name="title" id="title" size="50" type="text" value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="about">Step Information:</label>
                <?php show_fckeditor('about', isset($data['about']) ? $data['about'] : '' ); ?>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" class="form-control">
                    <option value="1" <?php echo (isset($data['status']) && $data['status'] == 1) ? 'selected="selected"' : ''; ?> >Enable</option>
                    <option value="0" <?php echo (isset($data['status']) && $data['status'] == 0) ? 'selected="selected"' : ''; ?> >Disable</option>
                </select>
            </div>
            <div class="form-group">
            <?php show_big_button('save', 'Save'); ?>
            </div>
        </div>
    </div>
</form>
