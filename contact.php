<?php
if ($_POST) {

require('constant.php');

    $user_name      = $_POST["name"];
    $user_email     = $_POST["email"];
    $user_phone     = $_POST["phone"];
    $content   = $_POST["content"];

    if (empty($user_name)) {
        $empty[] = "<b>Name</b>";
    }
    if (empty($user_email)) {
        $empty[] = "<b>Email</b>";
    }
    if (empty($user_phone)) {
        $empty[] = "<b>Phone Number</b>";
    }
    if (empty($content)) {
        $empty[] = "<b>Comments</b>";
    }

    if (!empty($empty)) {
        $output = json_encode(array('type' => 'error', 'text' => implode(", ", $empty) . ' Required!'));
        die($output);
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) { //email validation
        $output = json_encode(array('type' => 'error', 'text' => '<b>' . $user_email . '</b> is an invalid Email, please correct it.'));
        die($output);
    }
}
//reCAPTCHA validation
 