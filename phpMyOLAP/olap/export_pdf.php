<?php
include("../config.php");
include("../functions.php");
include("utility.php");

$cubename_sel=$_POST["cubename"];
$colonna=$_POST["ordinamento_col"];
$ordinamento=$_POST["ordinamento_type"];
$slice=$_POST["slice"];
$levels=unserialize(stripslashes($_POST['levels']));
$level_ser=implode("-",$levels);

$query=SQLgenerator2($cubename_sel,$level_ser,$slice,$colonna,$ordinamento);
$result=exec_query($query);
$ncols=mysql_num_fields($result);

define('FPDF_FONTPATH','../fpdf/font/');
require('../fpdf/fpdf.php');

$p = new fpdf();
$p->Open();
$p->AddPage();
$p->SetTextColor(0);
$p->SetFont('Arial', '', 8);

$w=10;
$h=10;
$off_h=5;
$off_w=40;

//***************************Heading
  for($i=0;$i<$ncols;$i++)
  {
    $colname=mysql_fetch_field($result);
    $nome=$colname->name;
    $tabella= $colname->table;
    
    if($tabella=="")
    $field="$nome";
    else
    $field="$tabella.$nome";
    
    $p->Text($w, $h, $field);
    $w=$w+$off_w;
  }
//****************************************


$w=10;
$h=$h+$off_h;

while ($row = mysql_fetch_array($result))
{
  for($i=0;$i<$ncols;$i++)
  {
    $colvalue=$row[$i];
    $p->Text($w, $h, $colvalue);
    $w=$w+$off_w;
  }
  $h=$h+$off_h;
  $w=10;

  if($h>200) 
    {
    $p->AddPage();
    $h=10;
    }
}

$pdf_filename = "olap_" . date("Ymd_His") . ".pdf";

$p->output($pdf_filename);

?>
