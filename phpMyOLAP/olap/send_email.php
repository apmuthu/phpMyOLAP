<?php
include("../config.php");
include("../functions.php");
include("utility.php");

$cubename=$_GET["cubename"];
$levels=$_GET["levels"];
$colonna=$_GET["ordinamento_col"];
$ordinamento=$_GET["ordinamento_type"];
$slice=$_GET["slice"];

//$shareurl="$urlsito/olap/report.php?parametri=$cubename*$levels*$colonna*$ordinamento*$slice";

print "<div style='margin-top:15px;margin-left:15px'>";
print "<b>Invia report link via email</b><br>";
print "<form action='send_email2.php' name=form_send_email method=post>";
print "Email<br>";
print "<input type=text name='email' id='email' size=50><br>";
print "Oggetto<br>";
print "<input type=text name='oggetto' id='oggetto' size=50><br>";
print "Testo<br>";
print "<textarea name='testo' id='testo' cols=50></textarea>";

//print "<input type=hidden id='hidden_shareurl' value='$shareurl'>";
print "<input type=hidden id='hidden_cubename' value='$cubename'>";
print "<input type=hidden id='hidden_levels' value='$levels'>";
print "<input type=hidden id='hidden_ordinamento' value='$ordinamento'>";
print "<input type=hidden id='hidden_colonna' value='$colonna'>";
print "<input type=hidden id='hidden_slice' value='$slice'>";

print "<p><table align=center>";
print "<tr align=center><td><a style='width:80px' class='button' href='#' onclick='send_email2()'>OK</a></td>";
print "<td><a style='width:80px' class='button' href='#' onclick=\"document.getElementById('DIVsend_email').style.visibility='hidden';\">Annulla</a></td></tr>";
print "</table>";

print "</form>";
print "</div>";


?>

