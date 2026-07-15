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
            if (empty($data['message'])) { $ok = false; $error_messages[] = 'Comment can not be blank.';};

            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $phone = $data['phone'];
            $message = $data['message'];
            if ($ok === true) {

                $email_content = "<p>Name: ".$first_name." ".$last_name."</p>";
                $email_content .= "<p>Email: ".$email."</p>";
                $email_content .= "<p>Phone: ".$phone."</p>";
                $email_content .= "<p>Message: ".$message."</p>";

		        $title = 'Feedback Form Enquiry Received - '. SITE_NAME;
		        $preheader = 'New Feedback Form Enquiry from website';
		        $heading = 'New Feedback Form Enquiry from website';
		        //$companyemail = COMPANY_EMAIL;
		        $companyemail = $settings['contact_mail']; //'property@hudson-moody.com';
		        //$companyfromemail = COMPANY_FROM_EMAIL;
		        $companyfromemail = $settings['contact_mail']; //'property@hudson-moody.com';
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
            		$fields = array('first_name','last_name','email','phone','message','sent_to','form_type','date_of_enquiry','status');
            		$data['date_of_enquiry'] = date('Y-m-d H:i:s');
		            $data['form_type'] = 'feedback';
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
										<input type="text" id="first_name" name="first_name" placeholder="First Name">
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="last_name" name="last_name" placeholder="Last Name">
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="email" name="email" placeholder="Email Address">
									</div>
									<div class="form__item form__item--type-text width50">
										<input type="text" id="phone" name="phone" placeholder="Phone Number">
									</div>
									<div class="form__item form__item--type-textarea">
										<textarea name="message" id="message"></textarea>
									</div>
									<div class="form__item form__item--type-checkbox">
										<div class="form__checkbox">
											<input type="checkbox" id="rent" name="search-type">
											<label for="rent">I Agree to the <a href="/t&cs">terms and conditions.</a> No Spam. We promise.</label>
										</div>
									</div>
									<div class="col-md-12">
										<div class="g-recaptcha col-xs-12 no-pad-lr" style="margin-bottom: 15px;" data-sitekey="<?= GOOGLE_RECAPTCHA_SITE; ?>"></div>
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