<!-- Careers Form -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="breadcrumbs">
				<ul>
					<li><a href="/">Home /</a></li>
					<li><a href="/careers">Careers</a></li>
				</ul>	
			</div>	
		</div>
	</div>
</div>

<div class="container">
	<div class="main_title">
		<h1>Career Form</h1>
	</div>

<?php
function send_smtp_attachment_emails($to, $from, $subject, $message, $file, $filename)
{
	$arr = array();
	
	if (strpos($to, ',') !== false) {
		$arr = explode(',', $to);
	} else {
		$arr = array($to);
	}
	
	record_form($subject, $message, 0);
	
	$message = nl2br($message);

		$mail             = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host       = SMTP_HOST; 
		$mail->SMTPAuth   = false;  
		$mail->SMTPSecure = SMTP_SECURE;
		$mail->Host       = SMTP_HOST;
		$mail->Port       = SMTP_PORT;
		$mail->Username   = SMTP_USERNAME;
		$mail->Password   = SMTP_PASSWORD;

		$mail->AddReplyTo($from);
		$mail->SetFrom($from);
		
		foreach ($arr as $to) {
			$mail->AddAddress($to);
		}
		
		if (($file != null) && ($filename != null)):
			$mail->AddAttachment($file, $filename);
		endif;
		
		$mail->Subject = $subject;
		
		$mail->AltBody = "If you want to view the message, use an HTML compatible email viewer!";
		
		$mail->MsgHTML($message);
		
		$mail->Send();

		return true;	
}

if (isset($_POST['contact-form-sent'])) 
{
	// if(isset($_POST['g-recaptcha-response'])) 
    // {
        // $captcha=$_POST['g-recaptcha-response'];
        
        // if(!$captcha){
          // $error_messages[] = 'Please check the captcha form';
      
        // }
        // $data = array(
            // 'secret' => GOOGLE_RECAPTCHA_SECRET,
            // 'response' => $captcha,
            // 'remoteip' => $_SERVER['REMOTE_ADDR']
        // );

		// $verify = curl_init();
		// curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		// curl_setopt($verify, CURLOPT_POST, true);
		// curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		// curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		// $response = curl_exec($verify);

		// $response=json_decode($response,true);
	
        // if($response['success'] == false)
        // {
          // $error_messages[] = 'Captcha Failed';
          
        // }
        // else
        // {
            $data = $_POST;
            $data = array_map('sanitize_sql_string', $data);
            $ok = true;
            
            if (empty($data['first_name'])) { $ok = false; $error_messages[] = 'First Name can not be blank.';};
            if (empty($data['last_name'])) { $ok = false; $error_messages[] = 'Last Name can not be blank.';};
            if (empty($data['email'])) { $ok = false; $error_messages[] = 'Email can not be blank.';};
            if (empty($data['phone'])) { $ok = false; $error_messages[] = 'Phone Number can not be blank.';};
            if (empty($data['message'])) { $ok = false; $error_messages[] = 'Comment can not be blank.';};
			
			$filename = $_FILES["resume"]["name"];
			$tempfile = $_FILES["resume"]["tmp_name"];
			
			$path1 = BASE_DIR ."uploads/resume/".$filename;
			move_uploaded_file($tempfile,$path1);
			
			$path = BASE_DIR ."uploads/resume/";
			$file = $path . $filename;

            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $phone = $data['phone'];
            $message = $data['message'];
            if($ok === true){

                $email_content = "<p>First Name: ".$first_name."</p>";
                $email_content .= "<p>Last Name: ".$last_name."</p>";
                $email_content .= "<p>Email: ".$email."</p>";
                $email_content .= "<p>phone: ".$phone."</p>";
                $email_content .= "<p>Message: ".$message."</p>";

		        $title = 'Job Application Received - '. SITE_NAME;
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
			
		        if(send_smtp_attachment_emails($systemEmails, $companyfromemail, $title, $message, $file, $filename)){
		        	
					$messages[] = '<p>Thank You. We appreciate that you’ve taken the time to write us. We’ll get back to you very soon.</p>';
					show_messages($messages);
					
					$fields = array('job_id','first_name','last_name','email','phone','file_name','message','description','status','created_at','updated_at');
            		$data['job_id'] = $_GET['id'];
            		$data['file_name'] = $filename;
            		$data['description'] = '';
            		$data['date_of_enquiry'] = date('Y-m-d H:i:s');
            		$data['created_at'] = date('Y-m-d H:i:s');
            		$data['updated_at'] = date('Y-m-d H:i:s');
		            $data['form_type'] = 'contact';
		            $data['sent_to'] = $systemEmails;
		            $data['status'] = 0;
		            table_insert('career', $fields, $data);
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
		            send_smtp_simple_emails($email, $companyfromemail, $title, $message);
		        }
				else
				{
					$error[] = 'Something went wrong. Try again later.';
					show_errors($error);
				}
		    }
        // }
	// }
}

?>
	<div class="career-form">
		<form method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group input_box col-md-6">
					<input name="first_name" type="text" class="form-control" placeholder="First Name" id="name" required>
				</div>
				<div class="form-group input_box col-md-6">
					<input name="last_name" type="text" class="form-control" placeholder="Last Name" id="lname" required>
				</div>
				<div class="form-group input_box col-md-6">
					<input name="email" type="email" class="form-control" placeholder="Email" id="email" required>
				</div>		
				<div class="form-group input_box col-md-6">
					<input name="phone" type="text" class="form-control" placeholder="Phone" id="phone" required>
				</div>
				<div class="form-group message-group col-md-12">
					<textarea class="form-control" name="message" cols="130" rows="7" placeholder="Message" required></textarea>
				</div>
				<div class="form-group message-group col-md-12">
					<input name="resume" type="file" id="resume">
				</div>
				<div class="submit_btn">
					<button type="submit" name="contact-form-sent" class="btn btn_submit">Submit</button>
				</div>
			 </div>					
		</form>
	</div>
</div>