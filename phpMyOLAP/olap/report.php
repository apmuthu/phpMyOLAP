<?php

include("../config.php");
include("../functions.php");
include("utility.php");
include("views/views.php");

$cubename_sel=$_POST['cube'];
$levels=$_POST["level_selected"];
$slice=$_POST['slice'];
$colonna=$_POST['colonna'];
$ordinamento=$_POST['ordinamento'];

if ($cubename_sel=="")
{
$parametri=$_GET['parametri'];
list($cubename_sel,$level_ser,$colonna,$ordinamento,$slice)=explode("*",$parametri);
$levels=explode("-",$level_ser);
}


printHTMLHead($stylefile,$jsfile);
printBar($cubename_sel,$levels,$img_back,$img_save,$img_home,$img_pdf,$img_csv,$img_share,$img_email,$img_weka);

print "<script>init_report(\"$colonna\",\"$ordinamento\");</script>";
 
$level_ser=implode("-",$levels);

//print "LEV $level_ser<br>";

$query=SQLgenerator2($cubename_sel,$level_ser,$slice,$colonna,$ordinamento);
$result=exec_query($query);

print "<center>";
print "<div id=divReport>";
printReport($cubename_sel,$levels,$result);
print "</div>";
print "</center>";


//*********************************************masks
include("slice/slice_mask.php");
include("drill/drill_mask.php");
include("hier/hier_mask.php");
include("dim/dim_mask.php");
include("drill-across/drill_mask.php");
include("pivoting/pivoting_mask.php");


print "<div id='share_fb' style='z-index:300; visibility:hidden;background-color: white; width:200px; height:100px; border: 2px grey solid;position:absolute;top:100px;left:150px;'>";
print "</div>";

print "<div id='DIVsend_email' style='z-index:300; visibility:hidden;background-color: white; width:500px; height:260px; border: 2px grey solid;position:absolute;top:100px;left:150px;'>";
print "</div>";

create_log($query);

footer();

?>