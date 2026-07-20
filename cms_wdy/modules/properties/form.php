<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
    $sites = get_active_sites();
    $selected_site_ids = array();
   

    if(isset($_POST['save']))
    {
        $fields = array('type','name','top_description','reference','price','price_qualifier','location','featured','size','amenities','content_1','internal_notes','meta_description','status');

        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('properties', $fields, $_POST);
            $messages[] = 'Saved successfully.';
           
        }
        else 
        {
            table_update('properties', $fields, $_POST, 'id=' . get_id());
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

        if( isset($_POST['delete-image']) ){
            foreach($_POST['delete-image'] as $image) {
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

        if(isset($_FILES['top_image']) && !empty($_FILES['top_image']['tmp_name'])) {

            $imgData = pathinfo($_FILES['top_image']['name']);
            $top_image = new AdvancedSimpleImage();
        
            $top_image->fromFile($_FILES['top_image']['tmp_name']);

            if ($top_image->getWidth() > 1000) {
                $top_image->resize(1000);
            }
            
            $top_image->toFile(UPLOADS_DIR . 'properties/' .$table_id . '-top.' . $imgData['extension']);

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
            $meta_image->toFile(UPLOADS_DIR . 'properties/' .$table_id . '-meta-image.' . $imgData['extension']);
        }

        if ($_FILES['floorplan_file']['name'] !== ''){
            $path_parts = pathinfo($_FILES['floorplan_file']['name']);
            $fileExtension = $path_parts['extension'];
            //$filename = str_replace(" ", "-", $_FILES['file']['name']);
            $filename = str_replace(' ', '-', $_POST['name']);
            $filename = $filename.'-floorplan.'.$fileExtension;
            //upload_file($_FILES['floorplan_file'], $table_id, 'documents',$filename,false);
            
            upload_media($_FILES['floorplan_file'],'floorplans',$filename);
        }
        if( isset($_POST['delete_floorplan']) ){
            foreach($_POST['delete_floorplan'] as $file) {
                if(file_exists('../' . $file) ) {
                    unlink('../' . $file);
                }
            }
        }

        sync_property_visibility_sites($table_id, $selected_site_ids);
        saveRewrite('properties',$table_id,'',$_POST['url']);
        // saveRewrite('property_gallery',$table_id,'',$_POST['gallery_url']);
        // saveRewrite('things_to_do',$table_id,'',$_POST['things_url']);
  
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('properties', 'id=' . $table_id); 
        if($data !== false) {
        	$data['url'] = getRewriteUrl('properties', $data['id']);
            $data['gallery_url'] = getRewriteUrl('property_gallery', $data['id']);
            $data['things_url'] = getRewriteUrl('things_to_do', $data['id']);
    		$date = date('d/m/Y H:i:s A', strtotime($data['publish_date']));
            $selected_site_ids = get_property_visibility_site_ids($data['id']);
        }
        $storeFolder = "../uploads/property_gallery_photos";
        $storePath = BASE_DIR."uploads/property_gallery_photos";
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

    <div class="form-group">
        <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Properties</h1>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            Property Information<a class="btn btn-sm btn-default float-right" data-toggle="collapse" data-target="#homepage_collapse" aria-expanded="true" aria-controls="homepage_collapse"><i class="fas fa-minus"></i></a>
        </div>
        <div id="homepage_collapse" class="collapse show" aria-labelledby="homepage_header">
            <div class="card-body">
                <div class="form-group">
                    <label for="top_image">Main Image: <span style="color:red;">(1000px by 635px)</span></label>
                    <input size="40" type="file" id="top_image" name="top_image" value="" class="form-control"  />
                </div>
                <div class="form-group">
                    <?php    
                    if($table_id > 0) {  
                	    $path = get_image('properties/' . $data['id'] . '-top');

                	    if (strlen($path) > 0):
                            ?>
                   
                	        <?php show_image('properties/' . $data['id'] . '-top'); ?>
                	        <label><input type="checkbox" name="delete-image[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
                	    
                        <?php endif; 
                    }?>
                </div>
                <div class="form-group">
                    <label for="type">Property Type:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="Sale" <?php echo (isset($data['type']) && $data['type'] == 'Sale') ? 'selected="selected"' : ''; ?> >Sale</option>
                        <option value="Rental" <?php echo (isset($data['type']) && $data['type'] == 'Rental') ? 'selected="selected"' : ''; ?> >Rental</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Property Name:</label>
                    <input class="required form-control" name="name" id="name" size="50" type="text" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="reference">Property Reference:</label>
                    <input class="form-control" name="reference" id="reference" size="50" type="text" value="<?php echo isset($data['reference']) ? $data['reference'] : ''; ?>" />
                </div>
                 <div class="form-group">
                    <label for="location">Property Location:</label>
                    <input class="form-control" name="location" id="location" size="50" type="text" value="<?php echo isset($data['location']) ? $data['location'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="price">Property Price: (exclude the currency symbol and any commas) eg) 240000 not €240,000</label>
                    <input class="form-control" name="price" id="price" size="50" type="text" value="<?php echo isset($data['price']) ? $data['price'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="price_qualifier">Property Price Qualifier: eg) PCM, ONO.  Leave blank if not required</label>
                    <input class="form-control" name="price_qualifier" id="price_qualifier" size="50" type="text" value="<?php echo isset($data['price_qualifier']) ? $data['price_qualifier'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="size">Property size: eg) 70 sq m</label>
                    <input class="form-control" name="size" id="size" size="50" type="text" value="<?php echo isset($data['size']) ? $data['size'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="content">Property Full Description:</label>
                    <?php show_fckeditor('content_1', isset($data['content_1']) ? $data['content_1'] : '' ); ?>
                </div>
                <div class="form-group">
                    <label for="featured">Featured Property?:</label>
                    <select name="featured" class="form-control">
                        <option value="1" <?php echo (isset($data['featured']) && $data['featured'] == 1) ? 'selected="selected"' : ''; ?> >Yes</option>
                        <option value="0" <?php echo (isset($data['featured']) && $data['featured'] == 0) ? 'selected="selected"' : ''; ?> >No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="content">Amenities:</label>
                    <?php show_fckeditor('amenities', isset($data['amenities']) ? $data['amenities'] : '' ); ?>
                </div>
                <div class="form-group">
                    <label for="internal_notes">Internal Notes (Not displayed on website):</label>
                    <?php show_fckeditor('internal_notes', isset($data['internal_notes']) ? $data['internal_notes'] : '' ); ?>
                </div>
            </div>
        </div>
    </div>
   
    <div class="card mb-4">
        <div class="card-header">
            Status & Meta<a class="btn btn-sm btn-default float-right" data-toggle="collapse" data-target="#status_collapse" aria-expanded="false" aria-controls="status_collapse"><i class="fas fa-plus"></i></a>
        </div>
        <div id="status_collapse" class="collapse" aria-labelledby="status_header">
            <div class="card-body">
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
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            Site Visibility
        </div>
        <div class="card-body">
            <p class="text-muted">Choose which websites should show this property. Both sites are selected by default for new properties.</p>
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
</form>
<div class="card mb-4">
    <div class="card-header">
        Gallery Images<a class="btn btn-sm btn-default float-right" data-toggle="collapse" data-target="#gallery_collapse" aria-expanded="false" aria-controls="gallery_collapse"><i class="fas fa-plus"></i></a>
    </div>
    <div id="gallery_collapse" class="collapse" aria-labelledby="gallery_header">
        <div class="card-body sortable-container">
            <?php if (!empty($table_id)){ ?>
                <form method="POST" action="/cms_wdy/modules/properties/uploadphotos.php" class="dropzone">
                    <input type="hidden" name="property_id" value="<?= $table_id;?>"/>
                </form>
                <?php //$photos = table_fetch_rows('module_images','table_id="'.$table_id.'" AND table_name = "vehicles" AND type = "FULL"','position ASC');
                    $photos = table_fetch_rows('property_gallery_photos','property_id="'.$table_id.'" AND media_type = "photo"','position ASC');
                if ($photos) {
                    echo '<div class="col-md-12" style="margin: 20px 0px;"><p>Uploaded Photos</p>';
                    echo '<div class="row sortable">';
                    foreach($photos as $photo) {?>
                        <div class="thumb-image-container" id="photo_<?= $photo['id']; ?>">
                            <img style="float:left; width: 200px;" src="<?= $storeFolder; ?>/<?= $photo['filename']; ?>?v1.1" alt="Photo - <?= $photo['position']; ?>" /><a href="#" class="delete-media" data-id="<?= $photo['id']; ?>" data-type="photo"><i class="fa fa-times"></i></a><a href="<?= $storeFolder; ?>/<?= $photo['filename']; ?>" data-lightbox="photo-<?= $table_id; ?>" data-id="<?= $photo['id']; ?>" data-type="photo"><i class="fa fa-eye"></i></a>
                        </div>
                    <?php }
                    echo '</div></div>';
                } ?>
            <?php }
            else{
                echo 'You will be able to upload images once you have saved the property';
            } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
	$('#name, #reference').keyup(function() {

        var val = $('#name').val();
        var reference = $('#reference').val();
        var type = $('#type').val();
        val =val+' '+reference;

        val = val.toLowerCase();
        val = val.replace(/[^a-z0-9 ]+/g, '');
        val = val.replace('  ', ' ');

        type = type.toLowerCase();
        type = type.replace(/[^a-z0-9 ]+/g, '');
        type = type.replace('  ', ' ');


        var url = '/properties/'+type+'/' + val.replace(/\s/g, '-');
    
        $('#url').val(url);

	});

    //Stuff for Dropzone
        $( ".sortable" ).sortable({
            revert: false,
            items: "> .thumb-image-container",
            cursor: "move",
            stop: function( event, ui ) {        
                ui.item.removeAttr("style");
            },
            update: function (event, ui) {
                var data = $(this).sortable('serialize') + '&id=<?= $table_id; ?>&table=properties';
               
                console.log(data);
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: data,
                    dataType: 'json',
                    type: 'POST',
                    url: '/cms_wdy/ajax/sort-media.php'
                })
                .done(function( result ) {
                    $('#overview-main-image').attr("src","<?= $storeFolder; ?>/" + result.main_photo_url);
                });
            }
            
        });   


        $('body').on('click', '.delete-media', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            var file = $(this).data('file');
            var $image = $(this).parents('.thumb-image-container');
            if (type == 'document') {
                var $tr = $(this).closest('tr');
            }
            if (confirm('Are you sure you want to delete this?')) {
                $.post('ajax/delete-media.php', 'id=' + id + '&type='+ type +'&table=property_gallery_photos', function() {
                    if (type == 'document') {
                        
                        $tr.remove();
                    } else {
                        $image.remove();
                    }
                })
            }
        })
        myDropzone.on("complete", function(file) {
          myDropzone.removeFile(file);
        });
});
</script>
<script>
    $(function () {
        //accordion the cards
        $('.card-header a.btn').click(function() {
           $(this).find('i').toggleClass('fa-minus');
           $(this).find('i').toggleClass('fa-plus');
        }) 
  });
</script>
