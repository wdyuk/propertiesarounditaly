<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
    $sites = get_active_sites();
    $selected_site_ids = array();
    
    if(isset($_POST['site_ids']) && is_array($_POST['site_ids'])) {
        $selected_site_ids = array_map('intval', $_POST['site_ids']);
    }
    
    if (!empty($table_id)) {
        $selected_site_ids = get_page_visibility_site_ids($table_id);
    }
    
    if (empty($selected_site_ids) && !empty($sites)) {
        foreach ($sites as $site) {
            $selected_site_ids[] = (int) $site['id'];
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $fields = array('parent_id','menu_title', 'page_title','meta_title','h1_title', 'content','content_2','content_3','content_4','content_5','content_6', 'meta_keywords', 'meta_description', 'target', 'status','top_nav','footer_nav');
        
        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('page', $fields, $_POST);
            $messages[] = 'Saved successfully.';
            
        }
        else 
        {
            table_update('page', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Saved successfully.';
        }  

        $selected_site_ids = isset($_POST['site_ids']) && is_array($_POST['site_ids'])
            ? array_map('intval', $_POST['site_ids'])
            : array();

        if (empty($selected_site_ids) && !empty($sites)) {
            foreach ($sites as $site) {
                $selected_site_ids[] = (int) $site['id'];
            }
        }

        sync_page_visibility_sites($table_id, $selected_site_ids);
        
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
        if(isset($_FILES['header-image']) && !empty($_FILES['header-image']['tmp_name'])) {

            $imgData = pathinfo($_FILES['header-image']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['header-image']['tmp_name']);

            if ($image->getWidth() > 1100) {
                $image->resize(1100);
            }
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-header-image.' . $imgData['extension']);

            // if ($image->getWidth() > 800) {
            //     $image->resize(800);
            // }
            // $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-medium.' . $imgData['extension']);
            // if ($image->getWidth() > 300) {
            //     $image->resize(300);
            // }
            // $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-small.' . $imgData['extension']);
        }
        if(isset($_FILES['mobile-header-image']) && !empty($_FILES['mobile-header-image']['tmp_name'])) {

            $imgData = pathinfo($_FILES['mobile-header-image']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['mobile-header-image']['tmp_name']);

            if ($image->getWidth() > 768) {
                $image->resize(768);
            }
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-mobile-header-image.' . $imgData['extension']);

            // if ($image->getWidth() > 800) {
            //     $image->resize(800);
            // }
            // $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-medium.' . $imgData['extension']);
            // if ($image->getWidth() > 300) {
            //     $image->resize(300);
            // }
            // $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-small.' . $imgData['extension']);
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
            $meta_image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-meta-image.' . $imgData['extension']);
        }

        if(isset($_FILES['static-image-1']) && !empty($_FILES['static-image-1']['tmp_name'])) {

            $imgData = pathinfo($_FILES['static-image-1']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['static-image-1']['tmp_name']);
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-static-image-1.' . $imgData['extension']);
        }
        if(isset($_FILES['static-image-2']) && !empty($_FILES['static-image-2']['tmp_name'])) {

            $imgData = pathinfo($_FILES['static-image-2']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['static-image-2']['tmp_name']);
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-static-image-2.' . $imgData['extension']);
        }
        if(isset($_FILES['static-image-3']) && !empty($_FILES['static-image-3']['tmp_name'])) {

            $imgData = pathinfo($_FILES['static-image-3']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['static-image-3']['tmp_name']);
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-static-image-3.' . $imgData['extension']);
        }
        if(isset($_FILES['static-image-4']) && !empty($_FILES['static-image-4']['tmp_name'])) {

            $imgData = pathinfo($_FILES['static-image-4']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['static-image-4']['tmp_name']);
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-static-image-4.' . $imgData['extension']);
        }
        if(isset($_FILES['static-image-5']) && !empty($_FILES['static-image-5']['tmp_name'])) {

            $imgData = pathinfo($_FILES['static-image-5']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['static-image-5']['tmp_name']);
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-static-image-5.' . $imgData['extension']);
        }
        if(isset($_FILES['static-image-6']) && !empty($_FILES['static-image-6']['tmp_name'])) {

            $imgData = pathinfo($_FILES['static-image-6']['name']);
            $image = new AdvancedSimpleImage();
        
            $image->fromFile($_FILES['static-image-6']['tmp_name']);
            
            $image->toFile(UPLOADS_DIR . 'page/' .$table_id . '-static-image-6.' . $imgData['extension']);
        }


        if(isset($_POST['delete-image'])){
            foreach($_POST['delete-image'] as $photo) {
                $image = get_image('module_images/' . $photo);
                if( file_exists('../' . $image) ) {
                    unlink('../' . $image);
                }
                table_delete_row('module_images', 'id='.$photo);
            }
        }
		if(isset($_FILES['photo'])) {
            bulk_upload_slider($_FILES['photo'], 'page', $table_id, $_POST['links']);
        }

        saveRewrite(TBL_PAGE,$table_id,'',$_POST['url']);
    }

    if (isset($_POST['update_text'])) {
        foreach ($_POST['update_text'] as $key => $value) {
            $fields = array('link');

            $data = array();
            $data['link'] = $value;
            

            table_update('module_images', $fields, $data, 'id=' . $key);
        }
    }
    
    if(!empty($table_id)) {
        $data = table_fetch_row('page', 'id=' . $table_id); 
        
        if($data !== false) {
            $data['url'] = getRewriteUrl(TBL_PAGE, $data['id']);
            $selected_site_ids = get_page_visibility_site_ids($data['id']);
        }
    }
    
    if (empty($selected_site_ids) && !empty($sites)) {
        foreach ($sites as $site) {
            $selected_site_ids[] = (int) $site['id'];
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
<input type="hidden" name="id" value="<?php echo $table_id; ?>" />
<input type="hidden" id="slug" value="" />
<div class="card mb-4">
    <div class="card-header">
        <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Page</h1>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="parent_id">Parent:</label>
        
                <?php
                        $first_node = array('id' => -1, 'menu_title' => '--');
                        $list = table_fetch_rows(TBL_PAGE, '', 'parent_id ASC, position ASC');

                        $tree = get_parent_child_array($list);
                        show_tree($tree, 'parent_id', 'select', 'id', 'menu_title', $first_node, isset($data['parent_id']) ? $data['parent_id'] : -1);
                ?>
        </div>
        <div class="form-group">
            <label for="menu_title">Menu Title:</label>
            <input class="required form-control" name="menu_title" id="menu_title" size="100" type="text" value="<?php echo isset($data['menu_title']) ? $data['menu_title'] : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="url">URL:</label>
            <input class="required form-control" name="url" id="url" size="100" type="text" value="<?php echo isset($data['url']) ? $data['url'] : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="page_title">Page Title:</label>
            <input class="form-control" name="page_title" id="page_title" size="100" type="text" value="<?php echo isset($data['page_title']) ? $data['page_title'] : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="meta_title">Meta Title:</label>
            <input class="form-control" name="meta_title" id="meta_title" size="100" type="text" value="<?php echo isset($data['meta_title']) ? $data['meta_title'] : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="h1_title">H1 Title:</label>
            <input class="form-control" name="h1_title" id="h1_title" size="100" type="text" value="<?php echo isset($data['h1_title']) ? $data['h1_title'] : ''; ?>" />
        </div>
        <?php if($data['id'] == 20){ ?>
            <div class="form-group">
                <label for="add-banners">Banner Slider Images:</label>
                <input size="40" class="btn btn-primary ml-2" type="button" id="add-banners" name="add-banners" value="Add Photo +" class=""  />
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
                            $photos = get_table_photos('page', $data['id'],'FULL');
                            $bannerCount = 0;
                            
                            if($photos != NULL):
                                echo "<span style='display:block;padding:5px;'>Check to delete.</span><span style='display:block;padding:5px;'>For external links add http:// at start. eg https://bbc.co.uk</span><span style='display:block;padding:5px;'>For internal links just type in info from URL field (See Above) on the edit page you wish to link to.</span><span style='display:block;padding:5px;'>eg /contact-us.html.</span>";
                                foreach($photos as $key => $photo):
                                    $bannerCount++;
                            ?>
                                <label>
                                    <img src="<?php echo $photo['file']; ?>" style="width:100px;" />
                                    <input class="form-control" type="checkbox" name="delete-image[]" value="<?php echo $key; ?>" />
                                </label>
                                    <input class="form-control" type="text" name="update_text[<?php echo $key ?>]" value="<?php echo $photo['link']; ?>" placeholder="Heading" />
                                    <br />
                                
                            <?php 
                                endforeach;
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        <?php }
        else {
        $bannerCount = 0; ?>
            <div class="row">
                <div class="col-md-12">
                    <label for="header-image">Static Header Image:</label>
                    <input class="form-control" name="header-image" id="header-image" size="100" type="file" />
                </div>
            </div>
            <?php
            if(isset($data['id'])) :
                    
                $path = get_image('page/' . $data['id'] . '-header-image');

                if (strlen($path) > 0):
                    ?>
                     <div class="row">
                        <div class="col-md-12">
                            <?php show_image('page/' . $data['id'] . '-header-image'); ?>
                            <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                        </div>
                    </div>
       
                <?php endif; 
            endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <label for="mobile-header-image">Static Mobile Header Image:</label>
                    <input class="form-control" name="mobile-header-image" id="mobile-header-image" size="100" type="file" />
                </div>
            </div>
            <?php
            if(isset($data['id'])) :
                    
                $path = get_image('page/' . $data['id'] . '-mobile-header-image');

                if (strlen($path) > 0):
                    ?>
                     <div class="row">
                        <div class="col-md-12">
                            <?php show_image('page/' . $data['id'] . '-mobile-header-image'); ?>
                            <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                        </div>
                    </div>
       
                <?php endif; 
            endif; ?>
        <?php } ?>
        
        <div class="form-group">
            <label for="links">Show Link:</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="top_nav" value="1" <?php echo (isset($data['top_nav']) && $data['top_nav'] == 1) ? 'checked="checked"' : ''; ?> />Main Navigation
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="footer_nav" value="1" <?php echo (isset($data['footer_nav']) && $data['footer_nav'] == 1) ? 'checked="checked"' : ''; ?> />Footer Navigation
                </label>
            </div>

        </div>
        <div class="card mb-4">
            <div class="card-header">
                Site Visibility
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?php foreach ($sites as $site) { ?>
                        <label class="d-block">
                            <input type="checkbox" name="site_ids[]" value="<?php echo (int) $site['id']; ?>" <?php echo in_array((int) $site['id'], $selected_site_ids, true) ? 'checked="checked"' : ''; ?> />
                            <?php echo htmlspecialchars($site['website_name']); ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
        </div>
   
        <div class="form-group">
            <label for="content">Main Content:</label>
            <?php show_fckeditor('content', isset($data['content']) ? $data['content'] : '' ); ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="static-image-1">1st Static Image:</label>
                <input class="form-control" name="static-image-1" id="static-image-1" size="100" type="file" />
            </div>
        </div>
        <?php
        if(isset($data['id'])) :
                
            $path = get_image('page/' . $data['id'] . '-static-image-1');

            if (strlen($path) > 0):
                ?>
                 <div class="row">
                    <div class="col-md-12">
                        <?php show_image('page/' . $data['id'] . '-static-image-1'); ?>
                        <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    </div>
                </div>
   
            <?php endif; 
        endif; ?>
        <div class="form-group">
            <label for="content">Content Block 2:</label>
            <?php show_fckeditor('content_2', isset($data['content_2']) ? $data['content_2'] : '' ); ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="static-image-2">2nd Static Image:</label>
                <input class="form-control" name="static-image-2" id="static-image-2" size="100" type="file" />
            </div>
        </div>
        <?php
        if(isset($data['id'])) :
                
            $path = get_image('page/' . $data['id'] . '-static-image-2');

            if (strlen($path) > 0):
                ?>
                 <div class="row">
                    <div class="col-md-12">
                        <?php show_image('page/' . $data['id'] . '-static-image-2'); ?>
                        <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    </div>
                </div>
   
            <?php endif; 
        endif; ?>
        <div class="form-group">
            <label for="content">Content Block 3:</label>
            <?php show_fckeditor('content_3', isset($data['content_3']) ? $data['content_3'] : '' ); ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="static-image-3">3rd Static Image:</label>
                <input class="form-control" name="static-image-3" id="static-image-3" size="100" type="file" />
            </div>
        </div>
        <?php
        if(isset($data['id'])) :
                
            $path = get_image('page/' . $data['id'] . '-static-image-3');

            if (strlen($path) > 0):
                ?>
                 <div class="row">
                    <div class="col-md-12">
                        <?php show_image('page/' . $data['id'] . '-static-image-3'); ?>
                        <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    </div>
                </div>
   
            <?php endif; 
        endif; ?>
        <!-- <div class="form-group">
            <label for="content">Content Block 4:</label>
            <?php show_fckeditor('content_4', isset($data['content_4']) ? $data['content_4'] : '' ); ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="static-image-4">4th Static Image:</label>
                <input class="form-control" name="static-image-4" id="static-image-4" size="100" type="file" />
            </div>
        </div>
        <?php
        if(isset($data['id'])) :
                
            $path = get_image('page/' . $data['id'] . '-static-image-4');

            if (strlen($path) > 0):
                ?>
                 <div class="row">
                    <div class="col-md-12">
                        <?php show_image('page/' . $data['id'] . '-static-image-4'); ?>
                        <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    </div>
                </div>
   
            <?php endif; 
        endif; ?>
        <div class="form-group">
            <label for="content">Content Block 5:</label>
            <?php show_fckeditor('content_5', isset($data['content_5']) ? $data['content_5'] : '' ); ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="static-image-5">5th Static Image:</label>
                <input class="form-control" name="static-image-5" id="static-image-5" size="100" type="file" />
            </div>
        </div>
        <?php
        if(isset($data['id'])) :
                
            $path = get_image('page/' . $data['id'] . '-static-image-5');

            if (strlen($path) > 0):
                ?>
                 <div class="row">
                    <div class="col-md-12">
                        <?php show_image('page/' . $data['id'] . '-static-image-5'); ?>
                        <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    </div>
                </div>
   
            <?php endif; 
        endif; ?>
        <div class="form-group">
            <label for="content">Content Block 6:</label>
            <?php show_fckeditor('content_6', isset($data['content_6']) ? $data['content_6'] : '' ); ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="static-image-6">6th Static Image:</label>
                <input class="form-control" name="static-image-6" id="static-image-6" size="100" type="file" />
            </div>
        </div>
        <?php
        if(isset($data['id'])) :
                
            $path = get_image('page/' . $data['id'] . '-static-image-6');

            if (strlen($path) > 0):
                ?>
                 <div class="row">
                    <div class="col-md-12">
                        <?php show_image('page/' . $data['id'] . '-static-image-6'); ?>
                        <label><input class="form-control" type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                    </div>
                </div>
   
            <?php endif; 
        endif; ?> -->
        <div class="row">
                <div class="col-md-12">
                    <label for="meta-image">Meta Image: Recommended size (1200px x 630px)</label>
                    <input class="form-control" name="meta-image" id="meta-image" size="100" type="file" />
                </div>
            </div>
            <?php
            if(isset($data['id'])) :
                    
                $path = get_image('page/' . $data['id'] . '-meta-image');

                if (strlen($path) > 0):
                    ?>
                     <div class="row">
                        <div class="col-md-12">
                            <?php show_image('page/' . $data['id'] . '-meta-image'); ?>
                            <label><input class="form-control" type="checkbox" name="delete-meta[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                        </div>
                    </div>
       
                <?php endif; 
            endif; ?>
        <div class="form-group">
            <label for="meta_description">Meta description:</label>
            <textarea cols="50" rows="3" class="form-control" name="meta_description" id="meta_description"><?php echo isset($data['meta_description']) ? $data['meta_description'] : ''; ?></textarea>
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

</form>

<script type="text/javascript">
$(function() {
    function getSlug(table,parent_id) {
        $.ajax({
            type: "POST",
            url: './ajax/get-slug.php',
            data: { 
                    parent_id : parent_id,
                    table : table },
            success: function(response)
            {
                var jsonData = JSON.parse(response);
 
                if (jsonData.success == "1")
                {
                    $('#slug').val(jsonData.slug);
                    var val = $('#menu_title').val();
                    var slug = $('#slug').val();
                   
                    
                    val = val.toLowerCase();
                    val = val.replace(/[^a-z0-9 ]+/g, '');
                    val = val.replace('  ', ' ');

                    slug = slug.toLowerCase();
                    slug = slug.replace(/[^a-z0-9 \/]/, '');
                    slug = slug.replace('  ', ' ');

                    var url = slug + val.replace(/\s/g, '-');
                    if (url == '/home') {
                        url = '/';
                    }
                    $('#url').val(url);
                }
                else
                {
                    alert('Invalid Credentials!');
                }
           }
       });
    }

    var parent_id = $('#parent_id').val();
    getSlug('page',parent_id);

    $('#parent_id').on('change', function() {
        var parent_id = $(this).val();
        getSlug('page',parent_id);  
    })
    $('#menu_title').keyup(function() {
        var val = $(this).val();
        var slug = $('#slug').val();
        $('#page_title,#h1_title').val(val);
        
        val = val.toLowerCase();
        val = val.replace(/[^a-z0-9 ]+/g, '');
        val = val.replace('  ', ' ');

        slug = slug.toLowerCase();
        slug = slug.replace(/[^a-z0-9 \/]/, '');
        slug = slug.replace('  ', ' ');

        var url = slug + val.replace(/\s/g, '-');
        if (url == '/home') {
            url = '/';
        }
        $('#url').val(url);
    });
    var bannerCount = <?php echo $bannerCount; ?>;
        
        $('#add-banners').click(function(){
            $('#photo-container').append('<input type="file" class="form-control" name="photo[' + bannerCount + ']" /><input type="text" class="form-control" name="links[' + bannerCount + ']" placeholder="Link" /><br />');
            bannerCount++;
        });
});
</script>
