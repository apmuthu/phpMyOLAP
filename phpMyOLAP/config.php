<?php
$authentication = false;
$auth_user = 'admin';
$auth_pass = 'password';

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "FoodMart";
$urlsito="http://localhost/phpMyOLAP";
$xmlfile="$urlsito/schema/FoodMart2.xml";
$stylefile="$urlsito/style/style.css";
$jsfile="$urlsito/script/script.js";

$extra = 'index.php';

$script_path = dirname($_SERVER['SCRIPT_NAME']). '/';
$script_name = $script_path . basename($_SERVER['SCRIPT_FILENAME']);
$script_pfx = '/' . basename($urlsito) . '/';

if ($authentication) {
	session_start();
	if ( !(($script_name == $script_pfx.'index.php') || ($script_name == $script_pfx.'home.php')) ) {
		if (!is_logged_in()) {
			header("Location: $urlsito/$extra");
			exit; 
		}
	}
} else {
	if ($script_name == $script_pfx.'index.php') {
		$extra = 'home.php';
		header("Location: $urlsito/$extra");
		exit; 
	}
}

include("images/images.php");

function is_logged_in() {
	return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
}

function auth($user, $pass) {
	global $auth_user, $auth_pass;
	$redirectpage='';
	if (!is_logged_in()) {
		if ($user == $auth_user && $pass == $auth_pass) {
			$_SESSION['logged_in'] = true;
		} else {
			unset($_SESSION['logged_in']);
			$redirectpage='index.php';
		}
	}
	return $redirectpage;
}
?>
