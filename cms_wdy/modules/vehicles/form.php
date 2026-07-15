<?php
    error_reporting(0);
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
    
    if(isset($_POST['save']))
    {
        $fields = array('title','registration','category','make','model','year','description','price','is_sold','status','meta_keywords','updated_at','reference_id','meta_title','kms','mileage','hours_used','bhp','serial_number','full_service_history','mot_date','v5_registration','manufacture_year','ulez_compliant','euro_status');
	
        if($table_id == 0) 
        {
            $table_id = table_insert('vehicles', $fields, $_POST);
            $messages[] = 'Saved successfully.';
            
        }
        else 
        {
            table_update('vehicles', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Updated successfully.';
        }

        saveRewrite('vehicles', $table_id,'',$_POST['url']);
    }

         
    if(!empty($table_id)) {
        $data = table_fetch_row('vehicles', 'id=' . $table_id); 
        if($data !== false) {
            	$data['url'] = getRewriteUrl('vehicles', $data['id']);
        }
        $storeFolder = "../uploads/vehicles";
        $storePath = BASE_DIR."uploads/vehicles";
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
            <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Vehicle</h1>
            <p>Please note images can't be added until the vehicle has been created, the image section will appear once the property has been saved</p>
        </div>
        <div class="card-body">
            <div class="form-row mb-3">
                <div class="col">
                    <label for="title">Title:</label>
                    <input class="required form-control" name="title" id="title" size="50" type="text" value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="registration">Registration:</label>
                    <input class="required form-control" name="registration" id="registration" size="50" type="text" value="<?php echo isset($data['registration']) ? $data['registration'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="category">Category</label>
                    <select name="category" class="form-control">
                        <option value="">Please select a category</option>
                        <?php $enabledcategories = table_fetch_rows('category', 'status = 1', 'name asc');
                        foreach ($enabledcategories as $cat) {?>
                            <option value="<?= $cat['id'];?>" <?php echo isset($data['category']) &&($data['category']== $cat['id']) ? 'selected="selected"' : NULL;?>><?= $cat['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="make">Make:</label>
                    <input class="required form-control" name="make" id="make" size="50" type="text" value="<?php echo isset($data['make']) ? $data['make'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="model">Model:</label>
                    <input class="required form-control" name="model" id="model" size="50" type="text" value="<?php echo isset($data['model']) ? $data['model'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="year">Year:</label>
                    <input class="required form-control" name="year" id="year" size="50" type="text" value="<?php echo isset($data['year']) ? $data['year'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="price">Price: <span style="color:red;">(£) e.g. 1000.00</span></label>
                    <input class="required form-control" name="price" id="price" size="50" type="text" value="<?php echo isset($data['price']) ? $data['price'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="kms">KMS: <span style="color:red;">(e.g. 100000)</span></label>
                    <input class="required form-control" name="kms" id="kms" size="50" type="text" value="<?php echo isset($data['kms']) ? $data['kms'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="mileage">Mileage: <span style="color:red;">(e.g. 100000)</span></label>
                    <input class="required form-control" name="mileage" id="mileage" size="50" type="text" value="<?php echo isset($data['mileage']) ? $data['mileage'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="hours_used">Hours Used: <span style="color:red;">(e.g. 100000)</span></label>
                    <input class="required form-control" name="hours_used" id="hours_used" size="50" type="text" value="<?php echo isset($data['hours_used']) ? $data['hours_used'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="bhp">BHP:</label>
                    <input class="required form-control" name="bhp" id="bhp" size="50" type="text" value="<?php echo isset($data['bhp']) ? $data['bhp'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="serial_number">Serial Number:</label>
                    <input class="required form-control" name="serial_number" id="serial_number" size="50" type="text" value="<?php echo isset($data['serial_number']) ? $data['serial_number'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="full_service_history">Full Service History:</label>
                    <input class="required form-control" name="full_service_history" id="full_service_history" size="50" type="text" value="<?php echo isset($data['full_service_history']) ? $data['full_service_history'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="mot_date">MOT Date:</label>
                    <input class="required form-control" name="mot_date" id="mot_date" size="50" type="text" value="<?php echo isset($data['mot_date']) ? $data['mot_date'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="v5_registration">V5 Registration:</label>
                    <input class="required form-control" name="v5_registration" id="v5_registration" size="50" type="text" value="<?php echo isset($data['v5_registration']) ? $data['v5_registration'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="manufacture_year">Manufacture Year:</label>
                    <input class="required form-control" name="manufacture_year" id="manufacture_year" size="50" type="text" value="<?php echo isset($data['manufacture_year']) ? $data['manufacture_year'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="ulez_compliant">Ulez Compliant:</label>
                    <input class="required form-control" name="ulez_compliant" id="ulez_compliant" size="50" type="text" value="<?php echo isset($data['ulez_compliant']) ? $data['ulez_compliant'] : ''; ?>" />
                </div>
                <div class="col">
                    <label for="euro_status">Euro Status:</label>
                    <input class="required form-control" name="euro_status" id="euro_status" size="50" type="text" value="<?php echo isset($data['euro_status']) ? $data['euro_status'] : ''; ?>" />
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="description">Description:</label>
                    <?php show_fckeditor('description', isset($data['description']) ? $data['description'] : '' ); ?>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="status">Meta keywords</label>
                    <textarea class="form-control" cols="50" rows="3" name="meta_keywords" id="meta_keywords"><?php echo stripslashes($data['meta_keywords']); ?></textarea>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="is_sold">Sold Status:</label>
                    <select name="is_sold" class="form-control">
                        <option value="0" <?php echo isset($data['is_sold'])&&($data['is_sold']==0) ? 'selected="selected"' : NULL;?>>For Sale</option>
                        <option value="1" <?php echo isset($data['is_sold'])&&($data['is_sold']==1) ? 'selected="selected"' : NULL;?>>Sold</option>
                    </select>
                </div>
                <div class="col">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?php echo (isset($data['status']) && $data['status'] == 1) ? 'selected="selected"' : ''; ?> >Enable</option>
                        <option value="0" <?php echo (isset($data['status']) && $data['status'] == 0) ? 'selected="selected"' : ''; ?> >Disable</option>
                    </select>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col">
                    <?php show_big_button('save', 'Save'); ?>
                </div>
            </div>
        </div>
    </div>
</form>
<?php if (!empty($table_id)){ ?>
<div class="card mb-4"><!-- Photos -->
    <div class="card-header">
        Photos
    </div>
    <div class="card-body sortable-container">
        <form method="POST" action="/cms_wdy/modules/vehicles/uploadphotos.php" class="dropzone">
            <input type="hidden" name="vehicle_id" value="<?= $table_id;?>"/>
        </form>
        <?php //$photos = table_fetch_rows('module_images','table_id="'.$table_id.'" AND table_name = "vehicles" AND type = "FULL"','position ASC');
            $photos = table_fetch_rows('vehicle_photos','vehicle_id="'.$table_id.'" AND media_type = "photo"','position ASC');
        if ($photos) {

            echo '<div class="col-md-12" style="margin: 20px 0px;"><p>Uploaded Photos</p>';
            echo '<div class="row sortable">';
            foreach($photos as $photo) {
                //$filepath = get_image_path('module_images/'.$photo['id'], true);
                //echo '<pre>'.print_r($filepath,true).'</pre>';
                //$file = get_image('module_images/'.$photo['id'].'');
                ?>
                <div class="thumb-image-container" id="photo_<?= $photo['id']; ?>">
                    <img style="float:left; width: 200px;" src="<?= $storeFolder; ?>/<?= $photo['filename']; ?>?v1.1" alt="Photo - <?= $photo['position']; ?>" /><a href="#" class="delete-media" data-id="<?= $photo['id']; ?>" data-type="photo"><i class="fa fa-times"></i></a><a href="<?= $storeFolder; ?>/<?= $photo['filename']; ?>" data-lightbox="photo-<?= $table_id; ?>" data-id="<?= $photo['id']; ?>" data-type="photo"><i class="fa fa-eye"></i></a>
                </div>
                <?php
            }
            echo '</div></div>';
        } ?>
    </div>
</div>
<?php } ?>
<?php require 'modules/delete.php'; ?>
<script type="text/javascript">
    $(function(){

        $('#title').keyup(function() {
            var val = $('#title').val();

            val = val.toLowerCase();
            val = val.replace(/[^a-z0-9 ]+/g, '');
            val = val.replace('  ', ' ');

            var url = '/vehicles/' + val.replace(/\s/g, '-');

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
                var data = $(this).sortable('serialize') + '&vehicle_id=<?= $table_id; ?>';
               
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
                $.post('ajax/delete-media.php', 'id=' + id + '&type='+ type +'&table=vehicle_photos', function() {
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