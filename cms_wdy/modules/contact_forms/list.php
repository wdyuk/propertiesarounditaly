<?php

	$limit = 15;
	$page = 1;
	
	if (isset($_GET['page'])) {
		$page = intval($_GET['page']);
	}
	
	$total_rows = table_row_count('contact_forms');
	$total_pages = ceil($total_rows / $limit);
	
	$rows = table_fetch_rows('contact_forms', '', 'date_of_enquiry DESC', ($page-1) * $limit, $limit);

	foreach ($rows as $key => $row) {
		$row['date_of_enquiry'] = date('d/m/Y H:i:s A',strtotime($row['date_of_enquiry']));
		if ($row['status'] == 1) {
			$status = '<span style="color:green"><strong>Resolved</strong></span>';
		} else {
			$status = '<span style="color:red"><strong>Unresolved</strong></span>';
		}
		$row['status'] = $status;
		$rows[$key] = $row;
	}

?>
<div class="card mb-4">
    <div class="card-header">
        Contact Forms
    </div>
    <div class="card-body">
        <div class="form-row align-items-center">
        	<table class="list">
        		<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Name</th>
						<th>Type</th>
						<th>Date of Enquiry</th>
						<th>Status</th>
					</tr>
				</thead>
			
				<tbody class="cursor-move">
				<?php 
					$operations = array('form', 'delete');
					show_rows($rows, 'contact_forms', array('c_name','form_type','date_of_enquiry','status'), $operations, false);
				?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="3"><?php show_pagination($total_pages, $page); ?></td>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<?php require 'modules/delete.php'; ?>


<script type="text/javascript">
$(function() {
	
	$('.operation').live('click', function() {
        
		var elm_class = $(this).attr('class'), value = $(this).attr('value');
		
		if (elm_class.indexOf('operation-form') > -1) {
			var location = 'control-panel.php?module=contact_forms&action=form&id=' + value;
			window.location = location;
		} else if (elm_class.indexOf('operation-delete') > -1) {
			var $li = $(this).parents('tr');
			
			if (confirm('Are you sure you want to delete this?')) {
				$.post('ajax/delete.php', 'id=' + value + '&table=contact_forms', function() {
					$li.remove();
				});
			}
		}
		
		return false;
	});
	
});
</script>

