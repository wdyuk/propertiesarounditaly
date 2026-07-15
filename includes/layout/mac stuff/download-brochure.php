<?php
$brochure = false;
    if (isset($_POST['contact-form-sent'])){
        if(isset($_POST['g-recaptcha-response'])){
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
                
                // if (empty($data['first_name'])) { $ok = false; $error_messages[] = 'First Name can not be blank.';};
                // if (empty($data['last_name'])) { $ok = false; $error_messages[] = 'Last Name can not be blank.';};
                // if (empty($data['email'])) { $ok = false; $error_messages[] = 'Email can not be blank.';};
                // if (empty($data['phone'])) { $ok = false; $error_messages[] = 'Phone Number can not be blank.';};

                $name = $data['name'];
                $company_name = $data['company_name'];
                $email = $data['email'];
                $mobile_number = $data['mobile_number'];
                if ($ok === true) {

                    /*$email_content = "<p>First Name: ".$name."</p>";
                    $email_content .= "<p>Business Name: ".$company_name."</p>";
                    $email_content .= "<p>Email: ".$email."</p>";
                    $email_content .= "<p>Mobile Number: ".$mobile_number."</p>";

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
                    
                    if(send_smtp_simple_email($systemEmails, $companyfromemail, $title, $message)){*/
                        
                        $messages[] = '<p>Thank You for filling out our form to download our Brochure click the button below</p>';
                        //show_messages($messages);
                        $brochure = true;
                        $fields = array('name','company_name','email','mobile_number','created_at');
                        $data['created_at'] = date('Y-m-d H:i:s');
                        table_insert('download_brochure', $fields, $data);
                        //$email = $data['email'];
                        // $client_content = "<p>Thank you for contacting us. One of the team will be in touch with you soon to discuss your query.<p>";
                        // $client_content .= $email_content;
                        // $client_title = 'Contact Enquiry Sent to - '. SITE_NAME.'';
                        // $client_preheader = 'Thank you for your enquiry';
                        // $client_heading = 'Thank you for your enquiry';
                        // $message = file_get_contents('includes/email_templates/base.html');
                        // $message = nl2br($message);
                        // $message = str_replace('{{BASE_URL}}', BASE_URL, $message);
                        // $message = str_replace('{{TITLE}}', $client_title, $message);
                        // $message = str_replace('{{PREHEADER}}', $client_preheader, $message);
                        // $message = str_replace('{{HEADING}}', $client_heading, $message);
                        // $message = str_replace('{{CONTENT}}', $client_content, $message);
                        // $message = str_replace('{{COMPANYEMAIL}}', $companyemail, $message);
                        // $message = str_replace('{{COMPANYADDRESS}}', $companyaddress, $message);
                        // $message = str_replace('{{LOGO}}', $companylogo, $message);
                        // $message = str_replace("<br>","",$message);
                        // $message = str_replace("<br />","",$message);
                        // $message = str_replace("\n","",$message);
                        // send_smtp_simple_email($email, $companyfromemail, $title, $message);
                    //}
                    /*else
                    {
                        $error[] = 'Something went wrong. Try again later.';
                        show_errors($error);
                    }*/
                }
            }
        } else {
            echo 'Captcha not filled';
        }
    }
?>
<div class="container">
    <div class="about_us">
        <div class="main_title">
            <h1><?= $pageData['h1_title']; ?></h1>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <?= $pageData['content1']; ?>
            </div>
            <div class="col-lg-6 col-sm-6">
                <?= $pageData['content2']; ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="contact_forms">
        <?php if ($brochure === true) { ?>
            <div class="col-md-12">
                <?php if(isset($messages) && !empty($messages)) {
                    echo '<div class="alert alert-success text-left">';
                    foreach($messages as $success) {
                        echo $success.'<br>';
                    }
                    echo '</div>';
                }?>
            </div>
            <div class="more_btn col-lg-12">
                <a href="/uploads/brochures/MAC-Schools-Brochure-A4.pdf">Download Brochure</a>
            </div>
        <?php } else{ ?>
            <form method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <?php if(isset($error_messages) && !empty($error_messages)) {
                            // show_errors($error_messages);
                            echo '<div class="alert alert-danger text-left">';
                            foreach($error_messages as $error) {
                                echo $error.'<br>';
                            }
                            echo '</div>';
                        }?>
                    </div>
                    <div class="form-group input_box col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" required/>
                    </div>
                    <div class="form-group input_box col-md-6">
                        <label for="company_name">Business Name</label>
                        <input type="text" name="company_name" class="form-control" placeholder="Business Name" required/>
                    </div>
                    <div class="form-group input_box col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required/>
                    </div>
                    <div class="form-group input_box col-md-6">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" required/>
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <div class="g-recaptcha" data-sitekey="<?= GOOGLE_RECAPTCHA_SITE; ?>"></div>  
                    </div>
                    <div class="submit_btn">
                        <button type="submit" name="contact-form-sent" class="btn btn_submit">Submit</button>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>  
</div>

<?php include('includes/template/accreditations.php'); ?>