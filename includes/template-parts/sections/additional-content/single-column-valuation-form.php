<?php
$success_messages = array();
$error_messages = array();
$message = '';
$params = $_POST;
	

if (isset($_POST['contact-form-sent'])) 
{

	if(isset($_POST['g-recaptcha-response'])) 
    {
        $captcha=$_POST['g-recaptcha-response'];
        
        if(!$captcha){
          $error_messages[] = 'Please check the captcha form';
      
        }
        $data = array(
            'secret' => GOOGLE_RECAPTCHA_SECRET,
            'response' => $captcha,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify);

		$response=json_decode($response,true);
	
        if($response['success'] == false)
        {
          $error_messages[] = 'Captcha Failed';
          
        }
        else
        {
            $data = $_POST;
            $data = array_map('sanitize_sql_string', $data);
            $ok = true;
            
            if (empty($data['first_name'])) { $ok = false; $error_messages[] = 'First Name can not be blank.';};
            if (empty($data['last_name'])) { $ok = false; $error_messages[] = 'Last Name can not be blank.';};
            if (empty($data['email'])) { $ok = false; $error_messages[] = 'Email can not be blank.';};
            if (empty($data['phone'])) { $ok = false; $error_messages[] = 'Telephone can not be blank.';};
            if (empty($data['office'])) { $ok = false; $error_messages[] = 'Office can not be blank.';};
            if (empty($data['valuation_type'])) { $ok = false; $error_messages[] = 'Type of Valuation can not be blank.';};
            if (empty($data['property_address'])) { $ok = false; $error_messages[] = 'Property Address can not be blank.';};
            if (empty($data['property_type'])) { $ok = false; $error_messages[] = 'Property Address can not be blank.';};
            if (empty($data['bedrooms'])) { $ok = false; $error_messages[] = 'Bedrooms can not be blank.';};
            // if (empty($data['message'])) { $ok = false; $error_messages[] = 'Comment can not be blank.';};

            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $phone = $data['phone'];
            $office = $data['office'];
            $valuation_type = $data['valuation_type'];
            $property_address = $data['property_address'];
            $property_type = $data['property_type'];
            $bedrooms = $data['bedrooms'];
            if ($ok === true) {

                $email_content = "<p>Name: ".$first_name." ".$last_name."</p>";
                $email_content .= "<p>Email: ".$email."</p>";
                $email_content .= "<p>Phone: ".$phone."</p>";
                $email_content .= "<p>Office: ".$office."</p>";
                $email_content .= "<p>Valuation Type: ".$valuation_type."</p>";
                $email_content .= "<p>Property Address: ".$property_address."</p>";
               	$email_content .= "<p>Property Type: ".$property_type."</p>";
                $email_content .= "<p>Bedrooms: ".$bedrooms."</p>";
                $email_content .= "<p>Additional Information: ".$message."</p>";

		        $title = 'Book Valuation Appointment Form Enquiry Received - '. SITE_NAME;
		        $preheader = 'New Book Valuation Appointment Form Enquiry from website';
		        $heading = 'New Book Valuation Appointment Form Enquiry from website';
		        //$companyemail = COMPANY_EMAIL;
		        $companyemail = 'property@hudson-moody.com';//$settings['contact_mail'];
		        //$companyfromemail = COMPANY_FROM_EMAIL;
		        $companyfromemail = 'property@hudson-moody.com';//$settings['contact_mail'];
		        $companyaddress = COMPANY_POSTAL_ADDRESS;
		        $companylogo = SITE_LOGO;
		        $message = file_get_contents('includes/email_templates/base.html');
		        $message = nl2br($message);
		        $message = str_replace('{{BASE_URL}}', BASE_URL, $message);
		        $message = str_replace('{{TITLE}}', $title, $message);
		        $message = str_replace('{{PREHEADER}}', $preheader, $message);
		        $message = str_replace('{{HEADING}}', $heading, $message);
		        $message = str_replace('{{CONTENT}}', $email_content, $message);
		        $message = str_replace('{{COMPANYEMAIL}}', $companyemail, $message);
				$message = str_replace('{{COMPANYADDRESS}}', $companyaddress, $message);
				$message = str_replace('{{LOGO}}', BASE_URL.$companylogo, $message);
		        $message = str_replace("<br>","",$message);
		        $message = str_replace("<br />","",$message);
		        $message = str_replace("\n","",$message);

		        $systemEmails = $settings['contact_mail_cnt_form'];
		        if(send_smtp_simple_email($systemEmails, $companyfromemail, $title, $message)){
		        	$success_messages[] = 'Your enquiry has been sent.';
            		$fields = array('first_name','last_name','email','phone','office','valuation_type','property_address','property_type','bedrooms','message','sent_to','form_type','date_of_enquiry','status');
            		$data['created_at'] = date('Y-m-d H:i:s');
		            $data['form_type'] = 'valuation appointment';
		            $data['sent_to'] = $systemEmails;
		            $data['status'] = 0;
		            table_insert('contact_forms', $fields, $data);
		            $email = $data['email'];
		            $client_content = "<p>Thank you for contacting us. One of the team will be in touch with you soon to discuss your query.<p>";
            		$client_content .= $email_content;
            		$client_title = 'Contact Enquiry Sent to - '. SITE_NAME.'';
		            $client_preheader = 'Thank you for your enquiry';
		            $client_heading = 'Thank you for your enquiry';
		            $message = file_get_contents('includes/email_templates/base.html');
		            $message = nl2br($message);
		            $message = str_replace('{{BASE_URL}}', BASE_URL, $message);
		            $message = str_replace('{{TITLE}}', $client_title, $message);
		            $message = str_replace('{{PREHEADER}}', $client_preheader, $message);
		            $message = str_replace('{{HEADING}}', $client_heading, $message);
		            $message = str_replace('{{CONTENT}}', $client_content, $message);
		            $message = str_replace('{{COMPANYEMAIL}}', $companyemail, $message);
		            $message = str_replace('{{COMPANYADDRESS}}', $companyaddress, $message);
		            $message = str_replace('{{LOGO}}', BASE_URL.$companylogo, $message);
		            $message = str_replace("<br>","",$message);
		            $message = str_replace("<br />","",$message);
		            $message = str_replace("\n","",$message);
		            send_smtp_simple_email($email, $companyfromemail, $title, $message);
		        }
		    }
        }
	}
};
?>

<section class="additional-content" id="area2">
	<div class="container">
		<div class="row">
			<div class="col mb-5">
				<div class="additional-content__content">
					<div class="row justify-content-center">
						<div class="col-lg-6 col-xs-12">
							<?php if (!empty($success_messages)) {
					            echo '<div class="col-xs-12 normal-text no-pad-lr" style="padding-right: 15px;"><div class="alert alert-success">';
					            foreach ($success_messages as $message) {
					                echo '<p>'.$message.'</p>';
					            };
					            echo '</div></div>';
					        };
				        	?>
				        	<?php if (!empty($error_messages)) {
					            echo '<div class="col-xs-12 normal-text no-pad-lr" style="padding-right: 15px;"><div class="alert alert-danger">';
					            foreach ($error_messages as $message) {
					                echo '<p>'.$message.'</p>';
					            };
					            echo '</div></div>';
					        }; ?>
							<div class="form">
								<form method="POST" enctype="multipart/form-data" class="form--type-contact">
									<div class="form__item form__item--type-text width50">
										<input type="text" id="first_name" name="first_name" placeholder="First Name" required>
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="email" id="email" name="email" placeholder="Email Address" required>
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="phone" name="phone" placeholder="Phone Number" required>
									</div>
									<div class="form__item form__item--type-text width50">
										<select class="form-select" name="office">
										  	<option selected>Please select an Office</option>
											<option value="City Centre">City Centre</option>
										  	<option value="Dunnington">Dunnington</option>
										  	<option value="Poppleton">Poppleton</option>
										  	<option value="Lettings">Lettings</option>
										</select>
									</div>
									<div class="form__item form__item--type-text width50">
										<select class="form-select" name="valuation_type">
											<option selected>Please select the type of valuation</option>
										  	<option value="Sales">Sales</option>
										  	<option value="Rent">Rent</option>
										</select>
									</div>
									<div class="form__item form__item--type-text">
										<input type="text" id="property_address" name="property_address" placeholder="Address of Property" required>
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="property_type" name="property_type" placeholder="Type of Property" required>
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="bedrooms" name="bedrooms" placeholder="Bedrooms" required>
									</div>
									<div class="form__item form__item--type-textarea">
										<textarea name="message" id="message" placeholder="Additional Information"></textarea>
									</div>
									<div class="form__item form__item--type-checkbox">
										<div class="form__checkbox">
											<input type="checkbox" id="rent" name="search-type">
											<label for="rent">I Agree to the <a href="/t&cs">terms and conditions.</a> No Spam. We promise.</label>
										</div>
									</div>
									<div class="col-md-12">
										<div class="g-recaptcha" style="margin-bottom: 15px;" data-sitekey="<?= GOOGLE_RECAPTCHA_SITE; ?>"></div>
									</div>
									<div class="form__item form__item--type-submit">
										<input type="submit" value="Submit" name="contact-form-sent">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>