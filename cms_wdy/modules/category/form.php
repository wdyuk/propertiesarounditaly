<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
   

    if(isset($_POST['save']))
    {
        $fields = array('name','description','status');

        
    

        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('category', $fields, $_POST);
            $messages[] = 'Saved successfully.';
           
        }
        else 
        {
            table_update('category', $fields, $_POST, 'id=' . get_id());
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
            $image->toFile(UPLOADS_DIR . 'categories/' .$table_id . '-icon.' . $imgData['extension']);

      //       if ($image->getWidth() > 1200) {
      //           $image->resize(1200);
      //       }
    		
    		// $image->toFile(UPLOADS_DIR . 'team/' .$table_id . '-large.' . $imgData['extension']);

    		// if ($image->getWidth() > 800) {
      //           $image->resize(800);
      //       }
      //       $image->toFile(UPLOADS_DIR . 'team/' .$table_id . '-medium.' . $imgData['extension']);
    		// if ($image->getWidth() > 300) {
      //           $image->resize(300);
      //       }
    		// $image->toFile(UPLOADS_DIR . 'team/' .$table_id . '-small.' . $imgData['extension']);

    	}

        if(isset($_FILES['meta-image']) && !empty($_FILES['meta-image']['tmp_name'])) {

            $imgData = pathinfo($_FILES['meta-image']['name']);
            $meta_image = new AdvancedSimpleImage();
            $meta_image->fromFile($_FILES['meta-image']['tmp_name']);

            if ($meta_image->getWidth() > 1200) {
                $meta_image->resize(1200);
                if($meta_image->getHeight() > 630) {
                    $meta_image->crop(0,0,1200,630);
                }
            }
            $meta_image->toFile(UPLOADS_DIR . 'category/' .$table_id . '-meta-image.' . $imgData['extension']);

        }
        saveRewrite('category',$table_id,'',$_POST['url']);
  
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('category', 'id=' . $table_id); 
        if($data !== false) {
        	$data['url'] = getRewriteUrl('category', $data['id']);
        }
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
    <input name="url" id="url" size="50" type="hidden" value="<?php echo isset($data['url']) ? $data['url'] : ''; ?>" />
    <div class="card mb-4">
        <div class="card-header">
            <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Category</h1>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name:</label>
                <input class="required form-control" name="name" id="name" size="50" type="text" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <?php show_fckeditor('description', isset($data['description']) ? $data['description'] : '' ); ?>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input size="40" type="file" id="image" name="image" value="" class="form-control"  />
            </div>
            <div class="form-group">
                <?php    
                if($table_id > 0) {  
                    $path = get_image('categories/' . $data['id'] . '-icon');

                    if (strlen($path) > 0):
                        ?>
               
                        <?php show_image('categories/' . $data['id'] . '-icon'); ?>
                        <label><input type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    
                    <?php endif; 
                }?>
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
<script type="text/javascript">
$(function() {
	$('#name').keyup(function() {
            var val = $('#name').val();

            val = val.toLowerCase();
            val = val.replace(/[^a-z0-9 ]+/g, '');
            val = val.replace('  ', ' ');

            var url = '/' + val.replace(/\s/g, '-');

            $('#url').val(url);  
	});
});
</script>
