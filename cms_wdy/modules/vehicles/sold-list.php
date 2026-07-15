<?php

	$sql = 'is_sold = 1';
	$sort_by = 'id asc';
	if(!empty($_POST))
	{
		$sql = '';
		if(isset($_POST['sold_status']))
		{
			$sql.= "is_sold = '{$_POST['sold_status']}' AND ";
		}

		/*if(!empty($_POST['query'])) 
		{
			$key = strtolower($_POST['query']);
			$sql .= "(LOWER(title) LIKE '%$key%' OR
			LOWER(general_content) LIKE '%$key%' OR
			LOWER(properties) LIKE '%$key%' OR
			LOWER(interior_content) LIKE '%$key%' OR
			LOWER(exterior_content) LIKE '%$key%' OR
			LOWER(service_record) LIKE '%$key%' OR
			LOWER(summary) LIKE '%$key%') AND ";
		}
		$sql = rtrim($sql,' AND ');
		$sort_by = !empty($_POST['price']) ? sprintf('price %s',$_POST['price']) : 'price desc, is_sold asc';
		$token = md5(time());
		$_SESSION['sql'] = $sql;
		$_SESSION['token'] = $token;
		$_SESSION['sort_by'] = $sort_by;*/
	}

	/*$token_op = false;
	if(isset($token) || isset($_REQUEST['search-token']))
	{
		$sql = $_SESSION['sql'];
		$sort_by = $_SESSION['sort_by'];
		$token_op = true;
	} else 
	{
		unset($_SESSION['token']);
		unset($_SESSION['sql']);
		//unset($_SESSION['sort_by']);
	}*/

	$limit = 25;
	$page = 1;
	
	if (isset($_GET['page'])) {
		$page = intval($_GET['page']);
	}
	
	$total_rows = table_row_count('vehicles',$sql);
	$total_pages = ceil($total_rows / $limit);
	
	$rows = table_fetch_rows('vehicles', $sql, $sort_by, ($page-1) * $limit, $limit);
	$rows = array_filter($rows,function(&$row){
		$row['is_sold'] = $row['is_sold'] == 1 ? 'Sold' : 'For sale';
		return $row;
	});
?>
<!-- <form action="?module=vehicles&action=list" method="POST">
	<table class="list">
		<thead>
			<tr>
				<td colspan="3"><h3>Search cars</h3></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type="text" name="query" placeholder="Search cars by name, description" style="width:100%;"/>
				</td>
				<td>
					<select name="vehicle_type" style="width:100%;">
						<option value="">Filter by Type</option>
						<option value="Car">Car</option>
						<option value="Commercial">Commercial</option>
					</select>
				</td>
				<td>
					<select name="sold_status" style="width:100%;">
						<option value="">Filter by status</option>
						<option value="">For Sale</option>
						<option value="1">Sold</option>
					</select>
				</td>
				<td>					
					<select name="price" style="width:100%;">
						<option value="">Sort by price</option>
						<option value="desc">High to low</option>
						<option value="asc">Low to high</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo show_big_button('Search','Search');?>
				</td>
			</tr>
		</tbody>
	</table>
</form> -->
<div class="card mb-4">
	<div class="card-header">
		Sold Vehicles
	</div>
	<div class="card-body">
		<div class="form-row align-items-center">
			<table class="list">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Display Name</th>
						<th>Make</th>
						<th>Model</th>
						<th>Price (&pound;)</th>
						<th>Sold status</th>
					</tr>
				</thead>
				<tbody class="cursor-move">
					<?php 
					$operations = array('form', 'delete');
					show_rows($rows, 'vehicles', array('display_name','make','model','price','is_sold'), $operations);
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
	<?php
		if($token_op)
		{
	?>
		var token = '<?php echo $_SESSION['token'];?>';
		$('ul.pagination li a').each(function(i,v){
			$(v).attr('href',$(v).attr('href')+'&search-token='+token);
		});
	<?php		
		}
	?>
	$('table.list > tbody').sortable({
                                            axis: 'y',
                                            opacity: 0.5,
                                            stop: function (evt, ui) {
                                                var arr = [];

                                                $('table.list > tbody tr').each(function(i) {
                                                        var row_id = $(this).attr('row_id');
                                                        arr[arr.length] = 'positions[' + row_id + ']=' + i;
                                                });

                                                var params = 'table=vehicles&' + arr.join('&');
                                                $.post('ajax/sort-order.php', params, function() {

                                                });
                                            }
					});
	
	$('.operation').live('click', function() {
        
		var elm_class = $(this).attr('class'), value = $(this).attr('value');
		
		if (elm_class.indexOf('operation-form') > -1) {
			var location = 'control-panel.php?module=vehicles&action=form&id=' + value;
			window.location = location;
		} else if (elm_class.indexOf('operation-delete') > -1) {
			var $li = $(this).parents('tr');
			
			if (confirm('Are you sure you want to delete this?')) {
				$.post('ajax/delete.php', 'id=' + value + '&table=vehicles', function() {
					$li.remove();
				});
			}
		}
		
		return false;
	});
	
});
</script>

