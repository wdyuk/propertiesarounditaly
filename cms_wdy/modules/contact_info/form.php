<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
   

    if(isset($_POST['save']))
    {
        $fields = array('address','monday','tuesday','wednesday','thursday','friday','saturday','sunday','facebook','twitter','instagram','status');

        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('contact_info', $fields, $_POST);
            $messages[] = 'Saved successfully.';
           
        }
        else 
        {
            table_update('contact_info', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Saved successfully.';
        }   

  
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('contact_info', 'id=' . $table_id); 
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
    <div class="card mb-4">
        <div class="card-header">
            <h1><?php echo ($table_id == 0) ? 'Add' : 'Edit'; ?> Contact Info</h1>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="address">Address:</label>
                <input class="required form-control" name="address" id="address" size="50" type="text" value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="monday">Monday Opening Times:</label>
                <input class="required form-control" name="monday" id="monday" size="50" type="text" value="<?php echo isset($data['monday']) ? $data['monday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="tuesday">Tuesday Opening Times:</label>
                <input class="required form-control" name="tuesday" id="tuesday" size="50" type="text" value="<?php echo isset($data['tuesday']) ? $data['tuesday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="wednesday">Wednesday Opening Times:</label>
                <input class="required form-control" name="wednesday" id="wednesday" size="50" type="text" value="<?php echo isset($data['wednesday']) ? $data['wednesday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="thursday">Thursday Opening Times:</label>
                <input class="required form-control" name="thursday" id="thursday" size="50" type="text" value="<?php echo isset($data['thursday']) ? $data['thursday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="friday">Friday Opening Times:</label>
                <input class="required form-control" name="friday" id="friday" size="50" type="text" value="<?php echo isset($data['friday']) ? $data['friday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="saturday">Saturday Opening Times:</label>
                <input class="required form-control" name="saturday" id="saturday" size="50" type="text" value="<?php echo isset($data['saturday']) ? $data['saturday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="sunday">Sunday Opening Times:</label>
                <input class="required form-control" name="sunday" id="sunday" size="50" type="text" value="<?php echo isset($data['sunday']) ? $data['sunday'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="facebook">Link to Facebook Page:</label>
                <input class="required form-control" name="facebook" id="facebook" size="50" type="text" value="<?php echo isset($data['facebook']) ? $data['facebook'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="twitter">Link to Twitter Page:</label>
                <input class="required form-control" name="twitter" id="twitter" size="50" type="text" value="<?php echo isset($data['twitter']) ? $data['twitter'] : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="instagram">Link to Instagram Page:</label>
                <input class="required form-control" name="instagram" id="instagram" size="50" type="text" value="<?php echo isset($data['instagram']) ? $data['instagram'] : ''; ?>" />
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
    </div>
</form>

