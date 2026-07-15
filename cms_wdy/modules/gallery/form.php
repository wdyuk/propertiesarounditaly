<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();   
    $table_id = 1;
   
    $storeFolder = "../uploads/gallery_photos";
    $storePath = BASE_DIR."uploads/gallery_photos";
    
    
?>


<div class="card mb-4">
    <div class="card-header">
        Gallery Images<a class="btn btn-sm btn-default float-right"><i class="fas fa-plus"></i></a>
    </div>
  
        <div class="card-body sortable-container">
            <?php if (!empty($table_id)){ ?>
                <form method="POST" action="/cms_wdy/modules/gallery/uploadphotos.php" class="dropzone">
                    
                </form>
                <?php //$photos = table_fetch_rows('module_images','table_id="'.$table_id.'" AND table_name = "vehicles" AND type = "FULL"','position ASC');
                    $photos = table_fetch_rows('gallery_photos','media_type = "photo"','position ASC');
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
            <?php } ?>
        </div>
    
</div>
<script type="text/javascript">
$(function() {
    
    //Stuff for Dropzone
    $( ".sortable" ).sortable({
            revert: false,
            items: "> .thumb-image-container",
            cursor: "move",
            stop: function( event, ui ) {        
                ui.item.removeAttr("style");
            },
            update: function (event, ui) {
                var data = $(this).sortable('serialize') + '&id=<?= $table_id; ?>&table=gallery';
               
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
                $.post('ajax/delete-media.php', 'id=' + id + '&type='+ type +'&table=gallery_photos', function() {
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
