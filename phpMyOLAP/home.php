<?php


include("config.php");
include("functions.php");

$redirectpage='';
if ( $authentication ) $redirectpage = auth($_POST['username'], $_POST['password']);

printHTMLHead($stylefile,$jsfile, $redirectpage);

print "<center><h2>phpMyOLAP Reports</h2></center>";
print "<table align=center>";
  print "<tr>";
    print "<td align=center>";
      print "<a href='builder/report.php'><img src='$img_new'><h3>Create Report</h3></a>";
    print "</td>";
    print "<td align=center>";
      print "<a href='builder/apri_report.php'><img src='$img_open'><h3>Open Report</h3></a>";
    print "</td>";
  print "</tr>";
print "</table>";

footer();
?>
