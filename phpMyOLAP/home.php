<?php
include("config.php");
include("functions.php");


printHTMLHead($stylefile,$jsfile);


print "<table align=center>";
  print "<tr>";
    print "<td align=center>";
      print "<a href='builder/report.php'><img src='$img_new'><h3>Crea report</h3></a>";
    print "</td>";
    print "<td align=center>";
      print "<a href='builder/apri_report.php'><img src='$img_open'><h3>Apri report</h3></a>";
    print "</td>";
  print "</tr>";
print "</table>";

print "<hr>";
print "<center>";
print "Sito web ufficiale <a href='http://phpmyolap.altervista.org'><b>phpmyolap.altervista.org</b></a>";
print "<p>E-mail <a href='mailto:phpmyolap@altervista.org'><b>phpmyolap@altervista.org</b></a>";

print "</center>";
?>
