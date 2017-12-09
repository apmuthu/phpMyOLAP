<?php

print "<div id='divDrill' style='z-index:300; visibility:hidden;background-color: white; width:400px; height:250px; border: 2px grey solid;position:absolute;top:100px;left:300px;margin-left:15px;margin-top:15px'>";

print "<center>";
print "<form id='form_report_drill' name='form_report_drill' action='../olap/report.php' method='post'>";

print "<table style='margin-top:15px' border=0>";
  print "<tr><td colspan=3 align=center><h4>$message[drill]</h4></td></tr>";
  print "<tr><td colspan=3 align=center><b>Select a Level</b></td></tr>";
  print "<tr>";
    print "<td valign=center align=center>";
      include "levels.php";
    print "</td>";
    print "<td valign=center align=center>";
      print "<img src='../images/arrow_up.png' width='50' height='50'><br>";
      print "<img src='../images/arrow_down.png' width='50' height='50'>";
    print "</td>";
    print "<td valign=center align=center>";
      print "<div id='divDrill2'>";
      print "</div>";
    print "</td>";
  print "</tr>";
print "</table>";

print "<table>";
  print "<tr>";
    print "<td>";
      print "<input type=hidden name=cube value='$cubename_sel'>";
      print "<input type=hidden name=colonna id=colonna value=''>";
      print "<input type=hidden name=ordinamento id=ordinamento value=''>";
      print "<input type=hidden name=slice id=slice value=''>";
    print "</td>";
    print "<td>";
      print "<a class='button' href='#' onclick='exec_drill(\"form_report_drill\")'>$message[ok]</a>";
    print "</td>";
    print "<td>";
      print "<a class='button' href='#' onclick=\"document.getElementById('divDrill').style.visibility='hidden';\">$message[cancel]</a>";
    print "</td>";
  print "</tr>";
print "</table>";

print "</form>";
print "</center>";

print "</div>";

?>
