<?php
$newsletter_success_messages = array();
$newsletter_error_messages = array();
$message = '';
$params = $_POST;
	

if (isset($_POST['newsletter-signup'])) 
{

	if(isset($_POST['g-recaptcha-response'])) 
    {
        $captcha=$_POST['g-recaptcha-response'];
        
        if(!$captcha){
          $newsletter_error_messages[] = 'Please check the captcha form';
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
          $newsletter_error_messages[] = 'Captcha Failed';
          
        }
        else
        {
            $data = $_POST;
        
            //$data = array_map('sanitize_sql_string', $data);
            $ok = true;
            
            if (empty($data['first_name'])) { $ok = false; $newsletter_error_messages[] = 'First Name can not be blank.';};
            if (empty($data['last_name'])) { $ok = false; $newsletter_error_messages[] = 'Last Name can not be blank.';};
            if (empty($data['email_address'])) { $ok = false; $newsletter_error_messages[] = 'Email can not be blank.';};

            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email_address'];
            if(isset($data['property_types'])){
	            $data['property_types'] = implode(',', $data['property_types']);
	        }
	        else{
	            $data['property_types'] = '';
	        }

            $property_types = $data['property_types'];
            if ($ok === true) {

                $email_content = "<p>Name: ".$first_name." ".$last_name."</p>";
                $email_content .= "<p>Email: ".$email."</p>";
                $email_content .= "<p>Property Types: ".$property_types."</p>";

		        $title = 'Newsletter Signup Received - '. SITE_NAME;
		        $preheader = 'Newsletter Signup Received from website';
		        $heading = 'Newsletter Signup Received from website';

		        //$companyemail = COMPANY_EMAIL;
		        $companyemail = $settings['contact_mail'];
		        //$companyfromemail = COMPANY_FROM_EMAIL;
		        $companyfromemail = $settings['contact_mail'];
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

		        if($property_types == 'sales'){
		        	$systemEmails = 'property@hudson-moody.com';
		        }
		        elseif($property_types == 'lettings'){
		        	$systemEmails = 'lettings@hudson-moody.com';
		        }
		        elseif($property_types == 'sales,lettings'){
		        	$systemEmails = 'property@hudson-moody.com , lettings@hudson-moody.com';
		        }
		        //$systemEmails = $settings['contact_mail_cnt_form'];
		        if(send_smtp_simple_email($systemEmails, $companyfromemail, $title, $message)){
		        	$newsletter_success_messages[] = 'You have now signed up for property alerts.';
            		$fields = array('first_name','last_name','email_address','property_types','sent_to','created_at');
            		$data['created_at'] = date('Y-m-d H:i:s');
            		$data['sent_to'] = $systemEmails;
		            table_insert('newsletter_signup', $fields, $data);
		            $email = $data['email_address'];
		            $client_content = "<p>Thank you for contacting us. One of the team will be in touch with you soon to discuss your query.<p>";
            		$client_content .= $email_content;
            		$client_title = 'Contact Enquiry Sent to - '. SITE_NAME.'';
		            $client_preheader = 'Thank you for Signing Up to New Property Alerts';
		            $client_heading = 'Thank you for Signing Up to New Property Alerts';
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
		    $newletter_submitted = true;
        }
	}
};
?>
