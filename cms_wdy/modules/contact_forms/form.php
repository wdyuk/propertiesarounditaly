<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */
    $messages = array();
    
    $table_id = get_id();
   

    if(isset($_POST['save']))
    {
        $fields = array('status');

        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('contact_forms', $fields, $_POST);
            $messages[] = 'Saved successfully.';
           
        }
        else 
        {
            table_update('contact_forms', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Saved successfully.';
        }   
  
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('contact_forms', 'id=' . $table_id); 
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
            <h1><?php echo ($table_id == 0) ? 'Add' : 'View'; ?> Enquiry</h1>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name"><strong>Type of Enquiry:</strong></label>
                <label for="name"><?= $data['form_type'];?></label>
            </div>
            <div class="form-group">
                <label for="name"><strong>Name:</strong></label>
                <label for="name"><?= $data['c_name'];?></label>
            </div>
            <div class="form-group">
                <label for="email"><strong>Email:</strong></label>
                <label for="email"><?= $data['c_email'];?></label>
            </div>
            <div class="form-group">
                <label for="telephone"><strong>Telephone Number:</strong></label>
                <label for="telephone"><?= $data['c_tel'];?></label>
            </div>
            <?php if($data['form_type'] == "contact"){?>
            <div class="form-group">
                <label for="message"><strong>Message:</strong></label>
                <label for="message"><?= $data['message'];?></label>
            </div>
            <?php }
            elseif ($data['form_type'] == "parts") {?>
            <div class="form-group">
                <label for="company_name"><strong>Company Name:</strong></label>
                <label for="company_name"><?= $data['company_name'];?></label>
            </div> 
            <div class="form-group">
                <label for="make"><strong>Make:</strong></label>
                <label for="make"><?= $data['make'];?></label>
            </div> 
            <div class="form-group">
                <label for="model"><strong>Model:</strong></label>
                <label for="model"><?= $data['model'];?></label>
            </div>
            <div class="form-group">
                <label for="chassis_number"><strong>Chassis Number:</strong></label>
                <label for="chassis_number"><?= $data['chassis_number'];?></label>
            </div>
            <div class="form-group">
                <label for="part_number"><strong>Part Number:</strong></label>
                <label for="part_number"><?= $data['part_number'];?></label>
            </div>
            <div class="form-group">
                <label for="part_description"><strong>Part Description:</strong></label>
                <label for="part_description"><?= $data['part_description'];?></label>
            </div>
            <?php }
            elseif ($data['form_type'] == "sell your vehicle") {?>
            <div class="form-group">
                <label for="company_name"><strong>Company Name:</strong></label>
                <label for="company_name"><?= $data['company_name'];?></label>
            </div> 
            <div class="form-group">
                <label for="make"><strong>Make:</strong></label>
                <label for="make"><?= $data['make'];?></label>
            </div> 
            <div class="form-group">
                <label for="model"><strong>Model:</strong></label>
                <label for="model"><?= $data['model'];?></label>
            </div>
            <div class="form-group">
                <label for="reg_number"><strong>Reg Number:</strong></label>
                <label for="reg_number"><strong><?= $data['reg_number'];?></strong></label>
            </div>
            <div class="form-group">
                <label for="chassis_number"><strong>Chassis Number:</strong></label>
                <label for="chassis_number"><?= $data['chassis_number'];?></label>
            </div>
            <div class="form-group">
                <label for="upload_image"><strong>Uploaded Image:</strong></label>
                <?php $path = get_image('sell_vehicles/' . $data['id'] . '-sell-vehicle'); 
                if (strlen($path) > 0):?>
                    <?php show_image('sell_vehicles/' . $data['id'] . '-sell-vehicle'); ?>
                <?php endif;?>
            </div>
        <?php } ?>
            <div class="form-group">
                <label for="status"><strong>Status:</strong></label>
                <select name="status" class="form-control">
                    <option value="1" <?php echo (isset($data['status']) && $data['status'] == 1) ? 'selected="selected"' : ''; ?> >Resolved</option>
                    <option value="0" <?php echo (isset($data['status']) && $data['status'] == 0) ? 'selected="selected"' : ''; ?> >Unresolved</option>
                </select>
            </div>
            <div class="form-group">
            <?php show_big_button('save', 'Save'); ?>
            </div>
        </div>
    </div>
</form>

