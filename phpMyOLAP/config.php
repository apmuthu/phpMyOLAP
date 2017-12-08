<?php
$phpmyolap_version = '1.3.3';

$authentication = false;
$auth_user = 'admin';
$auth_pass = 'password';

//default language file
$lang = "en.php";

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
$script_pfx = parse_url($urlsito);
$script_pfx = $script_pfx['path'] . '/';

if ($authentication) {
	session_start();
	if(isset($_POST["lang"])) $_SESSION["lang"] = $_POST["lang"];
	if(isset($_SESSION["lang"])) $lang = $_SESSION["lang"];
	if ( !(($script_name == $script_pfx.'index.php') || ($script_name == $script_pfx.'home.php')) ) {
		if (!is_logged_in()) {
			header("Location: $urlsito/$extra");
			exit; 
		}
	}
	if (is_logged_in() && isset($_GET['Logout']))
		logout();
} else {
	if(isset($_POST["lang"])) $lang = $_POST["lang"];
	if ($script_name == $script_pfx.'index.php') {
		$extra = 'home.php';
		header("Location: $urlsito/$extra");
		exit; 
	}
}

include("lang/$lang");
include("images/images.php");

function is_logged_in() {
	return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
}

function logout() {
	global $urlsito;
	if (isset($_SESSION['logged_in'])) unset($_SESSION['logged_in']);
	header("Location: $urlsito/index.php");
	exit; 
}

function langbox() {
	global $lang, $message;
	$out  = "<form name='langform' method='POST'>" . $message["lang"] . ': ';
	$out .= " <select name='lang' onchange='if(this.value != \"$lang\") { this.form.submit(); }'>\n";
	$mod_dir=dirname(__FILE__) . '/lang'; 
	$hnd=opendir($mod_dir);
	while($file=readdir($hnd)) {
		if ($file != "." and $file != "..") {
			if($file==$lang)
				$selected="selected";
			else
				$selected="";
  
			$nf = strlen($file);
			$file2=substr($file,0,$nf-4);
			$out .= "<option $selected value=$file>$file2</option>";
		}
	}
	$out .= "</select></form>";
	echo $out;
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

function footer() {
	global $phpmyolap_version, $authentication;
	print "<hr>";
	print "<center>";
	print    "<a href='http://phpmyolap.altervista.org'><b>Official Website</b></a>";
	print " &nbsp; | &nbsp; phpMyOLAP v<b>$phpmyolap_version</b>";
	print " &nbsp; | &nbsp; <a href='https://github.com/apmuthu/phpMyOLAP'><b>GitHub Repo</b></a>";
	if ($authentication && is_logged_in()) {
		print '&nbsp; | &nbsp; <a href="?Logout=1"><button>Logout</button></a><br>';
		print langbox();
	}
	print "</center>";
}
?>
