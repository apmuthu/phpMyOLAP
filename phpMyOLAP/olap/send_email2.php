<?php


include("../config.php");
include("../functions.php");
include("utility.php");

$cubename=$_GET["cubename"];
$levels=$_GET["levels"];
$colonna=$_GET["ordinamento_col"];
$ordinamento=$_GET["ordinamento_type"];
$slice=$_GET["slice"];
//$shareurl=$_GET["shareurl"];

$email=$_GET["email"];
$oggetto=$_GET["oggetto"];
$testo=$_GET["testo"];


$shareurl="$urlsito/olap/report.php?parametri=$cubename*$levels*$colonna*$ordinamento*$slice";

$messaggio="$testo\n$shareurl";
$mittente="From: phpMyOLAP";
$a=mail($email,$oggetto,$messaggio,$mittente);

print "<div style='margin-top:20px;margin-left:20px'>";
print "<center>";
if($a==true)
print "Email sent successfully";
else
print "Email not sent";
print "<br><br><br><a style='width:80px' class='button' href='#' onclick=\"document.getElementById('DIVsend_email').style.visibility='hidden';\">Close</a>";
print "</center>";
print "</div>";



?>

