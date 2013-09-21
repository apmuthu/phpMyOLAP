<?php

$dimensionname_sel=$_GET['dimension'];
$cubename_sel=$_GET['cubename'];

include("../config.php");
include("views/views.php");

$xml=simplexml_load_file($xmlfile);


//trova ultima dimensione
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
            }}}
      }
      $lastD=$dimensionname;
}}}
//***************************************



foreach($xml->Dimension as $dimension)
{
  $dimensionname=$dimension['name'];
  if($dimensionname==$dimensionname_sel)
  {
    foreach($dimension->Hierarchy as $hier)
    {
      $hiername=$hier['name'];
      printHier($cubename_sel,$dimensionname,$hiername,$lastD,$img_link,$img_lastlink,$img_plus,$img_hier);            
    }  
  }
}

  
?>
