<?php

print "<div id='divDrillAcross' style='z-index:300; visibility:hidden;background-color: white; width:450px; height:250px; border: 2px grey solid;position:absolute;top:100px;left:300px;margin-left:15px;margin-top:15px'>";
print "<div style='margin-top:15px;margin-left:15px;'>";

$hnd=opendir("../saved/");

print "<form action='drill-across/exec_across.php' name='drill_across' method=post target='_blank'>";
print "<table border=0 cellspacing=2 cellpadding=12>";
print "<tr>";
print "<td colspan=2>";
  print "<b>$message[drill_across]</b>";
print "</td>";
print "</tr>";

print "<tr>";
    print "<td>";
      print "Select the first report<br>";
      print "<select name=rep1>";
      while($file=readdir($hnd))
        if ($file != "." && $file != "..")
          print "<option value=\"$file\">$file</option>";
      print "</select>";
    print "</td>";

    print "<td>";
      rewinddir();
      print "Select the second report<br>";
      print "<select name=rep2>";
      while($file=readdir($hnd))
        if ($file != "." && $file != "..")
          print "<option value=\"$file\">$file</option>";
      print "</select>";
    print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
  print "<a style='width:120px' class='button' href='#' onclick='invia(\"drill_across\")';\">$message[ok]</a>";
print "</td>";
print "<td>";
  print "<a style='width:120px' class='button' href='#' onclick=\"document.getElementById('divDrillAcross').style.visibility='hidden';\">$message[close]</a>";
print "</td>";

print "</tr>";


print "</table>";

print "</form>";

print "</div>";
print "</div>";

?>
