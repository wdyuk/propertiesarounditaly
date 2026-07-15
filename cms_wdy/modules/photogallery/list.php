<?php

	$limit = 10;
	$page = 1;
	
	if (isset($_GET['page'])) {
		$page = intval($_GET['page']);
	}
	
	$total_rows = table_row_count(TBL_PHOTOGALLERY);
	$total_pages = ceil($total_rows / $limit);
	
	$rows = table_fetch_rows(TBL_PHOTOGALLERY, '', 'title ASC', ($page-1) * $limit, $limit);
?>
<table id="photogallery" class="list">
<thead>
<tr>
	<td colspan="2"><h1>Photogallery</h1></td>
</tr>
<tr>
	<th>&nbsp;</th>
	<th>Title</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
	<?php show_rows($rows, TBL_PHOTOGALLERY, array('title', 'date')); ?>
</tbody>
<tfoot>
<tr>
	<td colspan="2"><?php show_pagination($total_pages, $page); ?></td>
</tr>
</tfoot>
</table>

<script type="text/javascript">
$(function() {
	
	$('.delete, .operation-delete').click(function() {
		
		if (confirm("Are you sure you want to delete this?")) {
			var $tr = $(this).parents('tr');
			var row_id = $tr.attr('row_id'), table = $tr.attr('table');
			
			$.post('ajax/delete-gallery.php', 'id=' + row_id + '&table=' + table, function() {
				$tr.remove();
			});
			
			return false;
		}
	});
	
	$('#photogallery > tbody').sortable({
		axis: 'y',
		opacity: 0.5,
		stop: function(evt, ui) {
			var arr = [];
			
			$('#photogallery > tbody > tr').each(function(i) {
				arr[arr.length] = 'positions[' + $(this).attr('row_id') + ']=' + i;
			});
			arr[arr.length] = 'table=photogallery';
			
			var params = arr.join('&');
			$.post('ajax/sort-order.php', params, function() {
				
			});
		}
	}).disableSelection();
	
});
</script>