<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "yeo.raenyse@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "employer.html";
$feedback_page1 = "JobSeek.html";
$feedback_page2 = "index.html";
$error_page = "error_message.html";
$thankyou_page = "thankyou.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email_address = $_REQUEST['email_address'] ;
$message = $_REQUEST['message'] ;
$name = $_REQUEST['name'] ;
$subject = $_REQUEST['subject'];
$positioncompany = $_REQUEST['positioncompany'];
$linkedinprofile = $_REQUEST['linkedin'];
$msg = 
"Name: " . $name . "\r\n" . 
"Email: " . $email_address . "\r\n" . 
"Message: " . $message ;
"Subject: " . $subject;
"Position and Company: " . $positioncompany ;
"Linkedin Profile: " . $linkedinprofile ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

if (!isset($_REQUEST['email_address'])) {
header( "Location: $feedback_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($first_name) || empty($email_address)) {
header( "Location: $error_page" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email_address) || isInjected($name)  || isInjected($message) || isInjected($subject) || isInjected($positioncompany) || isInjected($linkedinprofile)) {
header( "Location: $error_page" );
}
		
elseif ( $name = test_input($_REQUEST["name"])) {
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $name = "Only letters and white space allowed";
    }
	
elseif ( $email_address = test_input($_REQUEST["email"])) {
    // check if name only contains letters and whitespace
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_address = "Invalid Email Format";
    }
  

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>