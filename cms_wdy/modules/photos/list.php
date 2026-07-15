<?php

	$limit = 10;
	$page = 1;
	
	if (isset($_GET['page'])) {
		$page = intval($_GET['page']);
	}
	
	$total_rows = table_row_count(TBL_ADMIN);
	$total_pages = ceil($total_rows / $limit);
	
	$rows = table_fetch_rows(TBL_PHOTOGALLERY, '', 'position ASC', ($page-1) * $limit, $limit);
?>
<table>
<tr>
	<td colspan="2"><h1>Photos</h1></td>
</tr>
<tr>
	<td width="100">Select gallery:</td>
    <td>
    	<?php
			$selected = array();
			
			if (isset($_GET['photogallery_id'])) {
				$selected = array($_GET['photogallery_id']);
			}
			
			$list = array_merge(array(array('id' => -1, 'title' => '--')), table_fetch_rows(TBL_PHOTOGALLERY, '', 'title ASC'));
			show_list($list, 'photogallery_id', 'id', 'title', 'select', $selected);
		?>
    </td>
</tr>
<tr>
	<td colspan="2">
	<?php
    if (isset($_GET['photogallery_id'])) {
        $where = sprintf('gallery_id = %d', $_GET['photogallery_id']);
        $gallery = table_fetch_rows(TBL_PHOTOS, $where, 'created_at DESC');
        
        if (count($gallery) == 0) {
			$messages = array('No record found');
            show_messages($messages);
        } else {
    ?>
    
    <ul id="gallery">
    <?php 
		foreach ($gallery as $photo) { 
	?>
    	<li row_id="<?php echo $photo['id']; ?>">
		<div class="row mb-3">
        	<div class="col-md-6">
            	<img src="<?=BASE_URL?>/uploads/gallery/<?php echo $photo['filename']; ?>" width='100' height="75" />
            </div>
			<div class="col-md-6">
				<!--div class="edit"><i class="fa fa-edit"></i></!--div-->
                <div class="delete"><i class="fa fa-trash" style="font-size:24px"></i></div>
			</div>	
			</div>		
        </li>
    <?php } ?>
    </ul>
    
    <?php
        }
    }
    ?>
	</td>
</tr>
</table>

<div id="photo-edit-box">
<form id="photo-edit-form" class="hidden" method="post" action="ajax/edit.php">
	<input type="hidden" name="table" value="<?php echo TBL_PHOTOS; ?>" />
    <input type="hidden" name="fields" value="title,description" />
    <input type="hidden" name="id" value="" />
    <table>
    <tr>
        <td>Title:</td>
        <td><input class="required" name="title" id="title" size="50" type="text" value="" /></td>
    </tr>
    <tr>
        <td valign="top">Description:</td>
        <td><textarea class="required" name="description" cols="47" rows="5" type="text"></textarea></td>
    </tr>
    </table>
</form>
</div>

<script type="text/javascript">
$(function() {
	$('.edit').click(function() {
		var $li = $(this).parents('li');
		var row_id = $li.attr('row_id');
		
		$.post('ajax/get.php', 'table=photos&id=' + row_id, function(r) {
			$('#photo-edit-form input[name=id]').val(r.id);
			$('#photo-edit-form input[name=title]').val(r.title);
			$('#photo-edit-form textarea[name=description]').val(r.description);
			
			$('#photo-edit-box').dialog('open');
		}, 'json');
	});
	
	$('#photo-edit-box').dialog({
		title: 'Edit Photograph',
		autoOpen: false,
		width: 500,
		height: 250,
		buttons: {
			'Save': function(evt, ui) {
				var $dialog = $(this);
				
				$.post('ajax/update.php', $('#photo-edit-form').serialize(), function() {
					$dialog.dialog('close');
				});
			},
			'Cancel': function(evt, ui) {
				$(this).dialog('close');
			}
		}
	});
	
	$('#gallery').sortable({
		stop: function(evt, ui) {
			var arr = [];
			
			$('#gallery > li').each(function(i) {
				arr[arr.length] = 'positions[' + $(this).attr('row_id') + ']=' + i;
			});
			arr[arr.length] = 'table=photos';
			
			var params = arr.join('&');
			$.post('ajax/sort-order.php', params, function() {
				
			});
		}
	}).disableSelection();
	
	$('#photogallery_id').change(function() {
		var photogallery_id = $(this).val();
		
		if (photogallery_id > -1) {
			window.location = '?module=photos&action=list&photogallery_id=' + photogallery_id;
		}
	});

	$('.delete').click(function() {
		
		if (confirm("Are you sure you want to delete this?")) {
			var $li = $(this).parents('li');
			var row_id = $li.attr('row_id'), table = 'photos';
			
			$.post('ajax/delete.php', 'id=' + row_id + '&table=' + table, function() {
				$li.remove();
			});
			
			return false;
		}
	});
	
});
</script>