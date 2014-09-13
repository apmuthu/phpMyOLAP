<?php

print "<script type='text/javascript' src='slice/script_slice.js' language='javascript'></script>";

print "<div id='divSD' style='z-index:300; visibility:hidden;background-color: white; width:1000px; height:300px; border: 2px grey solid;position:absolute;top:100px;left:150px;'>";
print "<center>";

print "<table border=0  width=100%>";
  print "<tr>";
    print "<td width=25%>";
      print "<div style='margin-left:20px;margin-top:10px;'><b>Dimension</b> in Cube <i>$cubename_sel</i></div>";
      include("slice/cubes.php");
    print "</td>";
    print "<td width=25%>";
      print "<div id='divHier'></div>";
    print "</td>";
    print "<td width=25%>";
      print "<div id='divLev'></div>";
    print "</td>";
    print "<td width=25%>";
      print "<div id='divProp'></div>";
    print "</td>";
  print "</tr>";
print "</table>";

print "<table>";
  print "<tr>";
    print "<td>";
      print "<input type=text id=a disabled='disabled'>";
    print "</td>";
    print "<td>";
      print "<select id=op name=op>";
      print "<option value='='>=";
      print "<option value='>'>>";
      print "<option value='>='>>=";
      print "<option value='<'><";
      print "<option value='<='><=";
      print "</select>";
    print "</td>";
    print "<td>";
      print "<input type=text name=cost id=cost>";
    print "</td>";
    print "<td>";
      print "<a class='button' href='#' onclick='addSD()'>Add</a>";
    print "</td>";
  print "</tr>";
  print "<tr>";
    print "<td colspan=3>";
      print "<select id='sd' name='sd' size=5 style='width:366px'>";
      
      // add the above conditions ( posted )
      $n=strlen($slice);
      $slice=substr($slice,0,$n-1);
      $cond=explode("-",$slice);
      $nc=count($cond);
      
      for($i=0;$i<$nc;$i++)
      if($cond[$i]!="") print "<option value=\"$cond[$i]\">$cond[$i]";
      
      //*************************
      
      print "</select>";
    print "</td>";
    print "<td valign='bottom'>";
      print "<a class='button' href='#' onclick='delSD()'>Clear</a>";
    print "</td>";
  print "</tr>";
print "</table>";

print "<table>";
  print "<tr>";
    print "<td align=center>";
      $level_ser=implode("-",$levels);
      print "<a class='button' href='#' onclick='slice(\"$level_ser\",\"$cubename_sel\");'>OK</a>";
    print "</td>";
    print "<td align=center>";
      print "<a class='button' href='#' onclick=\"document.getElementById('divSD').style.visibility='hidden';\">Cancel</a>";
    print "</td>";
  print "</tr>";
print "</table>";

print "</center>";
print "</div>";

?>
