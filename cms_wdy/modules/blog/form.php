<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
    $sites = get_active_sites();
    $selected_site_ids = array();
   

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $fields = array('title','publish_date','teaser','content','meta_description','status');

        
        $temp_date = explode('/',$_POST['publish_date']);
        $_POST['publish_date'] = $temp_date[2].'-'.$temp_date['1'].'-'.$temp_date[0];
    

        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('blog', $fields, $_POST);
            $messages[] = 'Saved successfully.';
           
        }
        else 
        {
            table_update('blog', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Saved successfully.';
        }   

        if (isset($_POST['site_ids']) && is_array($_POST['site_ids'])) {
            $selected_site_ids = array_map('intval', $_POST['site_ids']);
        }

        if (empty($selected_site_ids) && !empty($sites)) {
            foreach ($sites as $site) {
                $selected_site_ids[] = (int) $site['id'];
            }
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

            if ($image->getWidth() > 1200) {
                $image->resize(1200);
            }
    		
    		$image->toFile(UPLOADS_DIR . 'blog/' .$table_id . '-large.' . $imgData['extension']);

    		if ($image->getWidth() > 800) {
                $image->resize(800);
            }
            $image->toFile(UPLOADS_DIR . 'blog/' .$table_id . '-medium.' . $imgData['extension']);
    		if ($image->getWidth() > 300) {
                $image->resize(300);
            }
    		$image->toFile(UPLOADS_DIR . 'blog/' .$table_id . '-small.' . $imgData['extension']);

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
            $meta_image->toFile(UPLOADS_DIR . 'blog/' .$table_id . '-meta-image.' . $imgData['extension']);

        }
        sync_blog_visibility_sites($table_id, $selected_site_ids);
        saveRewrite('blog',$table_id,'',$_POST['url']);
  
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('blog', 'id=' . $table_id); 
        if($data !== false) {
        	$data['url'] = getRewriteUrl('blog', $data['id']);
    		$data['publish_date']= date('d/m/Y', strtotime($data['publish_date']));
            $selected_site_ids = get_blog_visibility_site_ids($data['id']);
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
    <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : 0 ; ?>" />
    <input name="url" id="url" size="50" type="hidden" value="<?php echo isset($data['url']) ? $data['url'] : ''; ?>" />
    <div class="card mb-4">
        <div class="card-header">
            <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Blog</h1>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="image">Image:</label>
                <input size="40" type="file" id="image" name="image" value="" class="form-control"  />
            </div>
            <div class="form-group">
                <?php    
                if($table_id > 0) {  
            	    $path = get_image('blog/' . $data['id'] . '-small');

            	    if (strlen($path) > 0):
                        ?>
               
            	        <?php show_image('blog/' . $data['id'] . '-small'); ?>
            	        <label><input type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
            	    
                    <?php endif; 
                }?>
            </div>
            <div class="form-group">
                <label for="title">Blog Title:</label>
                <input class="required form-control" name="title" id="title" size="50" type="text" value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="title">Publish Date:</label>
                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                    <input type="text" name="publish_date" class="form-control mb-2 datetimepicker-input" data-target="#datetimepicker1" value="<?php echo isset($data['publish_date']) ? $data['publish_date'] : ''; ?>"/>
                    <div class="input-group-append mb-2" data-target="#datetimepicker1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
               
            </div>
            <div class="form-group">
                <label for="content">Teaser Line:</label>
               
                <?php show_fckeditor('teaser', isset($data['teaser']) ? $data['teaser'] : '' ); ?>
                   
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
               
                <?php show_fckeditor('content', isset($data['content']) ? $data['content'] : '' ); ?>
                   
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="meta-image">Meta Image: Recommended size (1200px x 630px)</label>
                    <input class="form-control" name="meta-image" id="meta-image" size="100" type="file" />
                </div>
            </div>
            <?php
            if(!empty($table_id)) { 
                    
                $path = get_image('blog/' . $data['id'] . '-meta-image');

                if (strlen($path) > 0):
                    ?>
                     <div class="row">
                        <div class="col-md-12">
                            <?php show_image('blog/' . $data['id'] . '-meta-image'); ?>
                            <label><input class="form-control" type="checkbox" name="delete-meta[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                        </div>
                    </div>
       
                <?php endif; 
            } ?>
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
            <div class="card mb-4">
                <div class="card-header">
                    Site Visibility
                </div>
                <div class="card-body">
                    <p class="text-muted">Choose which websites should show this news story. Both sites are selected by default for new stories.</p>
                    <?php if (!empty($sites)) { ?>
                        <?php foreach ($sites as $site) { ?>
                            <div class="form-check mb-2">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="site_ids[]"
                                    id="site_<?= (int) $site['id']; ?>"
                                    value="<?= (int) $site['id']; ?>"
                                    <?= in_array((int) $site['id'], $selected_site_ids, true) ? 'checked="checked"' : ''; ?>
                                />
                                <label class="form-check-label" for="site_<?= (int) $site['id']; ?>">
                                    <?= htmlentities($site['website_name']); ?> <span class="text-muted">(<?= htmlentities($site['domain']); ?>)</span>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="text-muted mb-0">No active sites are available.</p>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
            <?php show_big_button('save', 'Save'); ?>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
$(function() {
	$('#title').keyup(function() {
            var val = $('#title').val();

            val = val.toLowerCase();
            val = val.replace(/[^a-z0-9 ]+/g, '');
            val = val.replace('  ', ' ');

            var url = '/blog/' + val.replace(/\s/g, '-');

            $('#url').val(url);  
	});
});
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
