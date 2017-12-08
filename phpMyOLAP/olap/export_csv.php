<?php
include("../config.php");
include("../functions.php");
include("utility.php");

ob_start();

$cubename_sel=$_POST["cubename"];
$levels=unserialize(stripslashes($_POST['levels']));
$level_ser=implode("-",$levels);
$colonna=$_POST["ordinamento_col"];
$ordinamento=$_POST["ordinamento_type"];
$slice=$_POST["slice"];


$query=SQLgenerator2($cubename_sel,$level_ser,$slice,$colonna,$ordinamento);
$result=exec_query($query);
$ncols=mysql_num_fields($result);


while ($row = mysql_fetch_array($result))
{
  for($i=0;$i<$ncols-1;$i++)
  {
    $colvalue=$row[$i];
    print "$colvalue,"; 
  }
  $colvalue=$row[$ncols-1];
  print "$colvalue";
  print "\n";
}


$contenuto=ob_get_contents();
ob_end_clean();

$csv_filename = "olap_" . date("Ymd_His") . ".csv";
header("Content-Type: application/text");
header("Content-Disposition: attachment; filename=$csv_filename");
print $contenuto;


?>
