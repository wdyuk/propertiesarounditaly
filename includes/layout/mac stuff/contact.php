<!-- Contact Page -->
<div class="banner_image">
	<?php
		$bannerImage = get_image('page/'. $pageData['id'] .'-large');
	?>
	<div class="img" style="background-image: url('<?= $bannerImage; ?>');"></div>
</div>

<div class="container">
	<div class="contact_info">
		<?php
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
		            if (empty($data['phone'])) { $ok = false; $error_messages[] = 'Phone Number can not be blank.';};
		            if (empty($data['message'])) { $ok = false; $error_messages[] = 'Comment can not be blank.';};

		            $first_name = $data['first_name'];
		            $last_name = $data['last_name'];
		            $email = $data['email'];
		            $phone = $data['phone'];
		            $message = $data['message'];
		            if ($ok === true) {

		                $email_content = "<p>First Name: ".$first_name."</p>";
		                $email_content .= "<p>Last Name: ".$last_name."</p>";
		                $email_content .= "<p>Email: ".$email."</p>";
		                $email_content .= "<p>phone: ".$phone."</p>";
		                $email_content .= "<p>Message: ".$message."</p>";

				        $title = 'Contact Form Enquiry Received - '. SITE_NAME;
				        $preheader = 'New Contact form Enquiry from website';
				        $heading = 'New Contact form Enquiry from website';
				        $companyemail = COMPANY_EMAIL;
				        $companyfromemail = COMPANY_FROM_EMAIL;
						$companylogo = BASE_URL . '/uploads/settings/1-image.png';
				        $companyaddress = COMPANY_POSTAL_ADDRESS;
				        $message = file_get_contents('includes/email_templates/base.html');
				        $message = nl2br($message);
				        $message = str_replace('{{BASE_URL}}', BASE_URL, $message);
				        $message = str_replace('{{TITLE}}', $title, $message);
				        $message = str_replace('{{PREHEADER}}', $preheader, $message);
				        $message = str_replace('{{HEADING}}', $heading, $message);
				        $message = str_replace('{{CONTENT}}', $email_content, $message);
				        $message = str_replace('{{COMPANYEMAIL}}', $companyemail, $message);
						$message = str_replace('{{COMPANYADDRESS}}', $companyaddress, $message);
						$message = str_replace('{{LOGO}}', $companylogo, $message);
				        $message = str_replace("<br>","",$message);
				        $message = str_replace("<br />","",$message);
				        $message = str_replace("\n","",$message);

				        $systemEmails = $settings['contact_mail_cnt_form'];
						
				        if(send_smtp_simple_email($systemEmails, $companyfromemail, $title, $message)){
				        	
							$messages[] = '<p>Thank You. We appreciate that you’ve taken the time to write us. We’ll get back to you very soon.</p>';
							show_messages($messages);

							$fields = array('first_name','last_name','email','phone','message','status','created_at','updated_at');
		            		$data['date_of_enquiry'] = date('Y-m-d H:i:s');
		            		$data['created_at'] = date('Y-m-d H:i:s');
		            		$data['updated_at'] = date('Y-m-d H:i:s');
				            $data['form_type'] = 'contact';
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
				            $message = str_replace('{{LOGO}}', $companylogo, $message);
				            $message = str_replace("<br>","",$message);
				            $message = str_replace("<br />","",$message);
				            $message = str_replace("\n","",$message);
				            send_smtp_simple_email($email, $companyfromemail, $title, $message);
				        }
						else
						{
							$error[] = 'Something went wrong. Try again later.';
							show_errors($error);
						}
				    }
		        }
			} else {
				echo 'Captcha not filled';
			}
		}
		?>
		<div class="main_title">
			<?php if(isset($messages) && !empty($messages)) {
				// show_errors($error_messages);
				echo '<div class="alert alert-success text-left">';
				foreach($messages as $success) {
					echo $success.'<br>';
				}
				echo '</div>';
			}?>
			<h1><?= $pageData['h1_title']; ?></h1>
		</div>
		<div class="sub_title">
			<?= $pageData['description']; ?>
		</div>
		<div class="our_info">
			<div class="row">
				<div class="col-lg-4 col-sm-4">
					<div class="our_add"><?= $pageData['content1']; ?></div>
				</div>
				<div class="col-lg-4 col-sm-4">
					<div class="our_add"><?= $pageData['content2']; ?></div>
				</div>
				<div class="col-lg-4 col-sm-4">
					<div class="our_add"><?= $pageData['content3']; ?></div>
				</div>
				<div class="col-lg-4 col-sm-4">
					<div class="our_add"><?= $pageData['content4']; ?></div>
				</div>
				<div class="col-lg-4 col-sm-4">
					<div class="our_add"><?= $pageData['content5']; ?></div>
				</div>
				<div class="col-lg-4 col-sm-4">
					<div class="our_add"><?= $pageData['content6']; ?></div>
				</div>
			</div>
		</div>	
		<div class="more_btn col-lg-12"><?= $pageData['content_title']; ?></div>
	</div>	
</div>

<div class="container">
	<div class="contact_forms">
		<div class="row">
			<div class="col-md-12">
				<form method="post" action="">
					<div class="row">
						<div class="form-group input_box col-md-6">
							<input name="first_name" type="text" class="form-control" placeholder="First name" id="name" required>
						</div>

						<div class="form-group input_box col-md-6">
							<input name="last_name" type="text" class="form-control" placeholder="Last name" id="lname" required>
						</div>
						<div class="form-group input_box col-md-6">
							<input name="email" type="email" class="form-control" placeholder="Email" id="email" required>
						</div>
						
						<div class="form-group input_box col-md-6">
							<input name="phone" type="text" class="form-control" placeholder="Phone" id="phone" required>
						</div>
						<div class="form-group message-group col-md-12">
							<textarea name="message" class="form-control" rows="7" placeholder="Message" required></textarea>
						</div>
						<div class="form-group col-md-12 text-center">
		                    <div class="g-recaptcha" data-sitekey="<?= GOOGLE_RECAPTCHA_SITE; ?>"></div>  
		                </div>
						<div class="form-check form-check-inline form-group col-md-12">
						  <label class="form-check-label" for="inlineCheckbox1"><input name="terms_check" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" required>I agree to the <a href="/tcs"> terms and conditions.</a> No spam. We promise.</label>
						</div>


						<div class="submit_btn">
							<button type="submit" name="contact-form-sent" class="btn btn_submit">Submit</button>
						</div>
					 </div> 		
				</form>
			</div>
		</div>
	</div>
</div>	

<?php include('includes/template/accreditations.php'); ?>