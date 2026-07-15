<?php 
        /*if( isset($_POST['delete']) ){
            foreach($_POST['delete'] as $image) {
                if( file_exists('../' . $image) ) {
                unlink('../' . $image);
                }
            }
        }*/
        /*if(isset($_FILES['main_image']) && !empty($_FILES['main_image']['tmp_name'])) {

            $imgData = pathinfo($_FILES['main_image']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['main_image']['tmp_name']);

            $image->resize(800,600);
            
            $image->toFile(UPLOADS_DIR . 'vehicles/' .$table_id . '-main-image.' . $imgData['extension']);

        }*/
        //upload_image($_FILES['main_image'], $table_id . '-main-image', 'vehicles');

        /*if( isset($_POST['delete-image']) ){
            foreach($_POST['delete-image'] as $photo) {
                table_delete_row('module_images', 'groupings="'. $photo . '"');
            }
        }*/

        /*if(isset($_FILES['photo'])) {
            bulk_upload_image($_FILES['photo'], 'vehicles', $table_id, $_POST['links']);
        }*/
        

        //$_POST['url'] = $_POST['make'].'-'.$_POST['model'].'-'.$reg.'.html';
        //$_POST['url'] = $_POST['name'];


?>
<div class="form-group">
    <label for="main_image">Main Image:</label>
    <input size="40" type="file" id="main_image" name="main_image" value="" class="form-control"  />
</div>
<div class="form-group">
    <?php if($table_id > 0) {  
        $path = get_image('vehicles/' . $data['id'] . '-main-image');
        if (strlen($path) > 0):?>
            <?php show_image('vehicles/' . $data['id'] . '-main-image'); ?>
            <label><input type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
        <?php endif; 
    }?>
</div>
<div class="form-group">
    <label for="add-images">Other Images:</label>
    <input size="40" class="btn btn-primary ml-2" type="button" id="add-images" name="add-images" value="Add Photo +" class=""  />
</div>
<div class="row">
    <div class="col-md-12">
        <div id="photo-container">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="photos">
        <?php 
            $photos = get_table_photos('vehicles', $data['id'], 'FULL');
            $imageCount = 0;
            
            if($photos != NULL):
                echo "<span style='display:block;padding:5px;'>Check to delete.</span>";
                echo '<ul class="sortable">';
                    foreach($photos as $key => $photo):
                        $imageCount++;?>
                        <li class="groupings" data-group="<?php echo $photo['group']; ?>">
                            <label>
                                <img src="<?php echo $photo['file']; ?>" style="width:100px;" />
                                <input type="checkbox" name="delete-image[]" value="<?php echo $photo['group']; ?>" />
                            </label>
                            <input type="hidden" name="update_links[<?php echo $key ?>]" value="<?php echo $photo['link']; ?>" placeholder="Link" />
                        </li>
                    <?php endforeach;
                echo '</ul>';
            endif;
        ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var imageCount = <?php echo $imageCount; ?>;
        
        $('#add-images').click(function(){
            $('#photo-container').append('<input type="file" class="form-control" name="photo[' + imageCount + ']" /><input type="text" class="form-control" name="links[' + imageCount + ']" placeholder="Link" /><br />');
            imageCount++;
        });
    });
</script>