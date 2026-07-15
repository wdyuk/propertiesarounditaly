<?php
    $messages = array();
    
    @$table_id = 1;

    if(isset($_POST['save']))
    {
        $fields = array('website_name', 'company_number', 'contact_mail', 'contact_number','contact_number_html','mobile_contact_number','mobile_contact_number_html', 'address','correspondence_address', 'map_link', 'contact_mail_cnt_form', 'facebook_link', 'youtube_link', 'twitter_link', 'snapchat_link', 'instagram_link', 'pinterest_link', 'google_link', 'linkedin_link', 'status');  

        if($_POST['id'] == 0) 
        {
            $table_id = table_insert('site_settings', $fields, $_POST);
            $messages[] = 'Saved successfully.';           
        }
        else 
        {
            table_update('site_settings', $fields, $_POST, 'id=' . get_id());
            $messages[] = 'Saved successfully.';
        }   

        if( isset($_POST['delete']) ){
            foreach($_POST['delete'] as $image) {
                if( file_exists('../' . $image) ) {
                    unlink('../' . $image);
                }
            }
        }

        if(isset($_FILES['logo']) && !empty($_FILES['logo']['tmp_name'])) {

            $imgData = pathinfo($_FILES['logo']['name']);
            $meta_image = new AdvancedSimpleImage();
            $meta_image->fromFile($_FILES['logo']['tmp_name']);

            if ($meta_image->getWidth() > 1200) {
                $meta_image->resize(1200);
                if($meta_image->getHeight() > 630) {
                    $meta_image->crop(0,0,1200,630);
                }
            }
            $meta_image->toFile(UPLOADS_DIR . 'settings/' .$table_id . '-image.' . $imgData['extension']);
        }
        saveRewrite('site_settings',$table_id,'',$_POST['url']);  
    }
     
    if($table_id > 0) {
        $data = table_fetch_row('site_settings', 'id=' . $table_id); 
        if($data !== false) {
        	$data['url'] = getRewriteUrl('site_settings', 1);
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

    <div class="card mb-4">
        <div class="card-header">
            <h1>Website Settings</h1>
        </div>
        <div class="card-body">
			
            <div class="form-group">
                <label for="website_name">Website Name:</label>
                <input class="required form-control" name="website_name" id="website_name" size="50" type="text" value="<?php echo isset($data['website_name']) ? $data['website_name'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="company_number">Company Number:</label>
                <input class="required form-control" name="company_number" id="company_number" size="50" type="text" value="<?php echo isset($data['company_number']) ? $data['company_number'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="logo">Logo:</label>
                <input size="40" type="file" id="logo" name="logo" value="" class="form-control"  />
            </div>
            <div class="form-group">
                <?php    
                if($table_id > 0) {  
            	    $path = get_image('settings/' . $data['id'] . '-image');

            	    if (strlen($path) > 0):
                        ?>
               
            	        <?php show_image('settings/' . $data['id'] . '-image'); ?>
            	        <label><input type="checkbox" name="delete[]" value="<?php echo $path; ?>" />&nbsp;Delete</label>
            	    
                    <?php endif; 
                }?>
            </div>
			
            <div class="form-group">
                <label for="contact_mail">Contact Email:</label>
                <input class="required form-control" name="contact_mail" id="contact_mail" size="50" type="email" value="<?php echo isset($data['contact_mail']) ? $data['contact_mail'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input class="required form-control" name="contact_number" id="contact_number" size="50" type="text" value="<?php echo isset($data['contact_number']) ? $data['contact_number'] : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="contact_number_html">Contact Number HTML: <span style="color: red;">(this number needs to start with +44 and have no spaces)</span></label>
                <input class="required form-control" name="contact_number_html" id="contact_number_html" size="50" type="text" value="<?php echo isset($data['contact_number_html']) ? $data['contact_number_html'] : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="mobile_contact_number">Contact Number:</label>
                <input class="required form-control" name="mobile_contact_number" id="mobile_contact_number" size="50" type="text" value="<?php echo isset($data['mobile_contact_number']) ? $data['mobile_contact_number'] : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="mobile_contact_number_html">Contact Number HTML: <span style="color: red;">(this number needs to start with +44 and have no spaces)</span></label>
                <input class="required form-control" name="mobile_contact_number_html" id="mobile_contact_number_html" size="50" type="text" value="<?php echo isset($data['mobile_contact_number_html']) ? $data['mobile_contact_number_html'] : ''; ?>" />
            </div>			
			<div class="form-group">
				<label for="address">Address:</label>
				<textarea cols="50" rows="3" class="form-control" name="address" id="address"><?php echo isset($data['address']) ? $data['address'] : ''; ?></textarea>
			</div>
            <div class="form-group">
                <label for="correspondence_address">Correspondence Address:</label>
                <textarea cols="50" rows="3" class="form-control" name="correspondence_address" id="correspondence_address"><?php echo isset($data['correspondence_address']) ? $data['correspondence_address'] : ''; ?></textarea>
            </div>
			
            <div class="form-group">
                <label for="map_link">Google Map Link:</label>
                <input class="required form-control" name="map_link" id="map_link" type="text" value="<?php echo isset($data['map_link']) ? $data['map_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="contact_mail_cnt_form">Contact Email for contact us form:</label>
                <input class="required form-control" name="contact_mail_cnt_form" id="contact_mail_cnt_form" size="" type="text" value="<?php echo isset($data['contact_mail_cnt_form']) ? $data['contact_mail_cnt_form'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="facebook_link">Facebook Link:</label>
                <input class="required form-control" name="facebook_link" id="facebook_link" type="text" value="<?php echo isset($data['facebook_link']) ? $data['facebook_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="linkedin_link">Linked in Link:</label>
                <input class="required form-control" name="linkedin_link" id="linkedin_link" type="text" value="<?php echo isset($data['linkedin_link']) ? $data['linkedin_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="twitter_link">Twitter Link:</label>
                <input class="required form-control" name="twitter_link" id="twitter_link" type="text" value="<?php echo isset($data['twitter_link']) ? $data['twitter_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="youtube_link">Youtube Link:</label>
                <input class="required form-control" name="youtube_link" id="youtube_link" type="text" value="<?php echo isset($data['youtube_link']) ? $data['youtube_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="instagram_link">Instagram Link:</label>
                <input class="required form-control" name="instagram_link" id="instagram_link" type="text" value="<?php echo isset($data['instagram_link']) ? $data['instagram_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="snapchat_link">Snapchat Link:</label>
                <input class="required form-control" name="snapchat_link" id="snapchat_link" type="text" value="<?php echo isset($data['snapchat_link']) ? $data['snapchat_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="pinterest_link">Pinterest Link:</label>
                <input class="required form-control" name="pinterest_link" id="pinterest_link" type="text" value="<?php echo isset($data['pinterest_link']) ? $data['pinterest_link'] : ''; ?>" />
            </div>
			
            <div class="form-group">
                <label for="google_link">Google Link:</label>
                <input class="required form-control" name="google_link" id="google_link" type="text" value="<?php echo isset($data['google_link']) ? $data['google_link'] : ''; ?>" />
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