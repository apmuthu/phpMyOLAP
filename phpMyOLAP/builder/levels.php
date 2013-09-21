<?php

$dimensionname_sel=$_GET['dimension'];
$hiername_sel=$_GET['hier'];
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
          printLevel($cubename_sel,$dimensionname,$hiername,$levelname,$lastH,$lastD,$img_link,$img_lastlink,$img_plus,$img_lev);
        }  
      }
    }      
  }
}

  
?>
