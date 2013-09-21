<?php
include("../config.php");
include("../functions.php");
include("utility.php");

$cubename=$_GET["cubename"];
$levels=$_GET["levels"];
$colonna=$_GET["ordinamento_col"];
$ordinamento=$_GET["ordinamento_type"];
$slice=$_GET["slice"];

$shareurl="$urlsito/olap/report.php?parametri=$cubename*$levels*$colonna*$ordinamento*$slice";

print "<div style='margin-top:10px'>";
print "<center>";

//facebook
print "<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";
print "<a icon_url='$img_report' name='fb_share' type='button_count' href='http://www.facebook.com/sharer.php?u=$shareurl' target='blank'>";
print "<img src='$img_fb' width=40px height=40px alt='condividi su facebook'/></a>";

//twittwee
print "<script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
print "<a href='#' onclick=\"window.open('http://twitter.com/share?url=$shareurl');return false;\" title=\"Condividi su Twitter\" target=\"_blank\">";
print "<img src='$img_tw' width=40px height=40px alt='condividi su facebook'/></a>";


//google
print "<a href='https://m.google.com/app/plus/x/?v=compose&content=$shareurl' onclick=\"window.open('https://m.google.com/app/plus/x/?v=compose&content=$shareurl')\",\"gplusshare\";\"return false;\" title=\"Condividi su Google Plus!\" target=\"_blank\">";
print "<img src='$img_google' width=40px height=40px alt='condividi su googleplus'>";
print "</a>";

//linkedin
//print "<script type='text/javascript' src='http://platform.linkedin.com/in.js'></script>";
//print "<script type='in/share' data-url='$shareurl' data-counter='top'></script>";
print "<a href='http://www.linkedin.com/shareArticle?mini=true&amp;url=$shareurl&amp;title=phpMyOLAP'  title='Condividi su LinkedIn' target=\"_blank\">";
print "<img src='$img_linkedin' width=40px height=40px alt='condividi su linkedin'>";
print "</a>";


print "<p><a style='width:120px' class='button' href='#' onclick=\"document.getElementById('share_fb').style.visibility='hidden';\">Chiudi</a>";
print "</center>";

print "</div>";

?>

	


