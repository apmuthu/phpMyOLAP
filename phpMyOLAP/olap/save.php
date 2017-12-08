<?php
include("../config.php");
include("../functions.php");
include("utility.php");

$cubename=$_GET["cubename"];
$levels=$_GET["levels"];
$ordinamento_col=$_GET["ordinamento_col"];
$ordinamento_type=$_GET["ordinamento_type"];
$slice=$_GET["slice"];

$nomereport=$_GET['nomereport'];
$nomefile="../saved/$nomereport.xml";
$filehandle=fopen($nomefile,'w') or die("Impossible to save report");

$cubename_tag="<cubename>$cubename</cubename>";
$levels_tag="<levels>$levels</levels>";
$ordinamento_col_tag="<order_col>$ordinamento_col</order_col>";
$ordinamento_type_tag="<order_type>$ordinamento_type</order_type>";
$slice_tag="<slice>$slice</slice>";

fwrite($filehandle,"<report>");
fwrite($filehandle,$cubename_tag);
fwrite($filehandle,$levels_tag);
fwrite($filehandle,$ordinamento_col_tag);
fwrite($filehandle,$ordinamento_type_tag);
fwrite($filehandle,$slice_tag);
fwrite($filehandle,"</report>");
fclose($filehandle);

print "Report saved"; 
?>
