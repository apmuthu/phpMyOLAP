<?php

$cubename_sel=$_GET['cube'];

include("../config.php");
include("aggregate_functions.php");
include("views/views.php");

$xml=simplexml_load_file($xmlfile);

foreach($xml->Cube as $cube)
{
  $cubename=$cube['name'];
  $cubetable=$cube->Table;
  $cubetablename=$cubetable['name'];

  if($cubename==$cubename_sel)
  {
    
    foreach($cube->Measure as $measure)
    {
    $measurecol=$measure['column'];
    $measurename=$measure['name'];
    if($measurecol!="")
    {
      printMeasure($cubename,$measurename,$img_plus,$img_lastlink,$img_mea,$img_del);
    }
    }
    
    foreach($cube->CalculatedMember as $calc_measure)
    {
      $calc_measurename=$calc_measure['name'];
      printMeasure($cubename,$calc_measurename,$img_plus,$img_lastlink,$img_mea,$img_del);
    }      
  }
}

  
?>
