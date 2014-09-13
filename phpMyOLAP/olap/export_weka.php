<?php
include("../config.php");
include("../functions.php");
include("utility.php");

ob_start();

$cubename_sel=$_POST["cubename"];
$colonna=$_POST["ordinamento_col"];
$ordinamento=$_POST["ordinamento_type"];
$slice=$_POST["slice"];
$levels=unserialize(stripslashes($_POST['levels']));
$level_ser=implode("-",$levels);

$query=SQLgenerator2($cubename_sel,$level_ser,$slice,$colonna,$ordinamento);
$result=exec_query($query);
$ncols=mysql_num_fields($result);




print "@RELATION report\n";    
 

//***************************Heading
  for($i=0;$i<$ncols;$i++)
  {
    $colname=mysql_fetch_field($result);
    $nome=$colname->name;
    $tabella= $colname->table;
    
    $numeric=$colname->numeric;
    if($numeric==1) $tipocampo="NUMERIC"; else $tipocampo="STRING";
    if($tabella=="")
    $field="$nome";
    else
    $field="$tabella.$nome";

    print "@ATTRIBUTE $field $tipocampo\n";    
  }
//****************************************


print "@DATA\n";

while ($row = mysql_fetch_array($result))
{
  $riga="";
  for($i=0;$i<$ncols;$i++)
  {
    $colvalue=$row[$i];
    $riga.="$colvalue,";   
  }
  $n=strlen($riga);
  $riga=substr($riga,0,$n-1);

  print "$riga\n";   

}


$contenuto=ob_get_contents();
ob_end_clean();

$arff_filename = "olap_" . date("Ymd_His") . ".arff";
header("Content-Type: application/text");
header("Content-Disposition: attachment; filename=$arff_filename");
print $contenuto;

?>
