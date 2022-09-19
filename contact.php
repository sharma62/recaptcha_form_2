<?php
if ($_POST) {
	require('constant.php');

	$user_name      = $_POST["name"];
	$user_email     = $_POST["email"];
	$user_address   = $_POST["address"];
	$user_phone     = $_POST["phone"];
	$content   		= $_POST["content"];

	if (empty($user_name)) {
		$empty[] = "<b> Name</b>";
	}
	if (empty($user_email)) {
		$empty[] = "<b>Email</b>";
	}
	if (empty($user_address)) {
		$empty[] = "<b>Address</b>";
	}
	if (empty($user_phone)) {
		$empty[] = "<b>Phone Number</b>";
	}
	if (empty($content)) {
		$empty[] = "<b>Comments </b>";
	}

	if (!empty($empty)) {
		$output = json_encode(array('type' => 'error', 'text' => implode(", ", $empty) . ' Required!'));
		die($output);
	}

	if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) { //email validation
		$output = json_encode(array('type' => 'error', 'text' => '<b>' . $user_email . '</b> is an invalid Email, please correct it.'));
		die($output);
	}

	$conn = mysqli_connect('localhost', 'root', '', 'test');
	//reCAPTCHA validation
	if (isset($_POST['g-recaptcha-response'])) {

		require('component/recaptcha/src/autoload.php');

		$recaptcha = new \ReCaptcha\ReCaptcha(SECRET_KEY);

		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if ($resp->isSuccess()) {
			// send data into database 
			mysqli_query($conn, "INSERT INTO `data_table`( `name`, `email`, `mobile`, `massage`, `address`)
									VALUES ('$user_name','$user_email','$user_phone','$content','$user_address')");
	    $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_name .', Thanks for Connecting. We will get back to you shortly.'));
		die($output);
		}

		if (!$resp->isSuccess()) {
			$output = json_encode(array('type' => 'error', 'text' => '<b>Captcha</b> Validation Required!'));
			die($output);
		}
	}
}
