<?php


$dimensionname_sel=$_GET['dimension'];
$hiername_sel=$_GET['hier'];
$levelname_sel=$_GET['level'];
$cubename_sel=$_GET['cubename'];

include("../config.php");
include("views/views.php");


$xml=simplexml_load_file($xmlfile);

//*************************************conta
foreach($xml->Cube as $cube)
{
$cubename=$cube['name'];
if($cubename==$cubename_sel)
{
foreach($cube->DimensionUsage as $dimension)
{
$dimensionname=$dimension['name'];
if($dimensionname==$dimensionname_sel) 
{
foreach($xml->Dimension as $dimension)
{
  $dimensionname2=$dimension['name'];
  if($dimensionname2==$dimensionname_sel)
  {
    foreach($dimension->Hierarchy as $hier)
    {
      $hiername=$hier['name'];
      if($hiername==$hiername_sel)
      {
        foreach($hier->Level as $level)
        {
          $levelname=$level['name'];  
          $lastL= $levelname;           
        }  
      }
      $lastH=$hiername;
    }      
  }
}
}
$lastD=$dimensionname;
}}}
//********************************************


foreach($xml->Dimension as $dimension)
{
  $dimensionname=$dimension['name'];
  if($dimensionname==$dimensionname_sel)
  {
    foreach($dimension->Hierarchy as $hier)
    {
      $hiername=$hier['name'];
      if($hiername==$hiername_sel)
      {
        foreach($hier->Level as $level)
        {
          $levelname=$level['name'];
          $levelcol=$level['column'];
          if ($levelname==$levelname_sel)
          {
            foreach($level->Property as $prop)
            {
              $propname=$prop['name'];
              printProp($dimensionname,$lastD,$hiername,$lastH,$levelname,$propname,$lastL,$img_link,$img_lastlink,$img_prop,$img_del);
            }            
          }              
        }  
      }
    }      
  }
}

  
?>
