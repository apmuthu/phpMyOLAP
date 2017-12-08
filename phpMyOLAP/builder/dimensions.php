<?php

include("../config.php");
include("views/views.php");


$cubename_sel=$_GET['cube'];

$xml=simplexml_load_file($xmlfile);

foreach($xml->Cube as $cube)
{
  $cubename=$cube['name'];
  if($cubename==$cubename_sel)
  {
    foreach($cube->DimensionUsage as $dimension)
    {
      $dimensionname=$dimension['name'];
      printDimension($cubename,$dimensionname,$img_lastlink,$img_plus,$img_dim);     
    }  
  }
}


?>
