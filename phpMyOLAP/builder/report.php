<?php

include("../config.php");
include("../functions.php");


$operazione=$_POST['operazione'];


printHTMLHead($stylefile,$jsfile);
print "<table width=100%><tr><td valign=top><a href='../home.php' title='Home'><img src='$img_home' width=35px height=35px></a></td>";
print "<td>";
printLegend($img_cube,$img_mea,$img_dim,$img_hier,$img_lev,$img_prop);
print "</td></tr></table>";
 

print "<center>";
print "<form id='form_report' name='form_report' action='../olap/report.php' method='post'>";

print "<table cellspacing=5 cellpadding=5 width=100% border=0>";
  print "<tr>";
    print "<td width=30% valign='top'>";
      print "<script>init_images('$img_minus','$img_plus')</script>";
      include_once("cubes.php");
      print "<p>";
      print "<div id='divTree'>";
      print "</div>";
    print "</td>";

    print "<td valign=top align=center>";
      //*************************************************REPORT **************************************************
      print "<table border=1 id='report'>";
        print "<tr id='rep_header'>";
        print "</tr>";
      print "</table>";
      //print "<p><a style='width:120px' class='button' href='#' onclick='invia(\"form_report\")'>Create Report</a>";
      print "<p><a style='width:120px' class='button' href='#' onClick='check_cube2()'>Create Report</a>";
      print "<br>";
      //**********************************************Selected Data
      print "<select id='level_selected' size=5 name='level_selected[]' multiple style='visibility:hidden'>";
      include_once("checkback.php");
      print "</select>";
    print "</td>";
  print "</tr>";
print "</table>";

print "</form>";
print "</center>";

footer();
?>
