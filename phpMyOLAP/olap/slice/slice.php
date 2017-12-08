<?php
include("../../config.php");
include("../../functions.php");
include("../utility.php");


$level_ser=$_GET['levels'];
$slice=$_GET['slice'];
$colonna=$_GET['colonna'];
$ordinamento=$_GET['ordinamento'];
$cubename_sel=$_GET["cubename"];

$query=SQLgenerator2($cubename_sel,$level_ser,$slice,$colonna,$ordinamento);
//print "$query<br>"; 
$result=exec_query($query);
$levels=explode("-",$level_ser);
printReport($cubename_sel,$levels,$result);
 
  
?>
