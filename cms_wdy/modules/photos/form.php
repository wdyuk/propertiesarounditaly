<table width="100%">
<tr>
	<td colspan="2"><h1>Add Photos</h1></td>
</tr>
<tr>
	<td>Gallery:</td>
    <td>
		<select name="photogallery_id" id="photogallery_id" class="form-control">
			<!-- <option value="">Select</option> -->
			<!-- <option value="144">Gallery</option> -->
			<option value="149">Brands</option>
		</select>
    </td>
</tr>
<tr>
	<td colspan="2">
		<div class="card mb-4"><!-- Photos -->
			<div class="card-header">
				Upload New Documents
			</div>
			<div class="card-body sortable-container">
				<form method="POST" action="modules/photos/uploaddocuments.php" class="dropzone">
					<input type="hidden" name="gallery_id" id="gallery_id" value="149"/>
				</form>
			</div>
		</div>
	</td>
</tr>
</table>
<script type="text/javascript">
$(function() {
	$('#photogallery_id').on('change', function() {
        var pageid = $(this).val();
		$('#gallery_id').val(pageid);
    })
});
</script>