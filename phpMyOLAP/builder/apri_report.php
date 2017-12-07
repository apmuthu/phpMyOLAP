<?php

include("../config.php");
include("../functions.php");

printHTMLHead($stylefile,$jsfile);

print "<a href='../home.php'><img src='$img_home' width=35px height=35px></a>";
print "<div style='margin-left:25px'>";
print "<h2>Saved Reports</h2>";
print "</div>";

$hnd=opendir("../saved/");
while($file=readdir($hnd))
{
  if ($file != "." && $file != "..")
  {
    print_form($file);
  }
}

footer();


function print_form($xmlfile)
{
$n=strlen($xmlfile);
$nomefile=substr($xmlfile,0,$n-4);
$xmlfile="../saved/$xmlfile";
$xml=simplexml_load_file($xmlfile);

$cubename=$xml->cubename;
$colonna=$xml->order_col;
$ordinamento=$xml->order_type;
$slice=$xml->slice;
$levels_ser=$xml->levels;
$levels=explode("-",$levels_ser);
$nl=count($levels);
$nj=0;

print "<div style='margin-left:25px'>";
print "<form name=form_apri_$nomefile action='../olap/report.php' method=post>";
print "<input type=hidden name=cube value='$cubename'>";
print "<input type=hidden name=colonna value='$colonna'>";
print "<input type=hidden name=ordinamento value='$ordinamento'>";
print "<input type=hidden name=slice value='$slice'>";
print "<select id='level_selected' name='level_selected[]' multiple style='visibility:visible;width:1px;height:1px'>";
for($i=0;$i<$nl;$i++) 
  print "<option value=\"$levels[$i]\" selected>";
print "</select>";

print "<a href='#' onclick='document.form_apri_$nomefile.submit()'>$nomefile</a>";
print "</form>";
print "</div>";

}
  
?>
