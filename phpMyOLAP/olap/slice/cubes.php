<?php

//include_once("../../config.php");

$xml=simplexml_load_file($xmlfile);
  
foreach($xml->Cube as $cube)
{
  $cubename=$cube['name'];
  if($cubename==$cubename_sel)
  {
    print "<select id='dimension' name='dimension' size=5 onclick='discoverHier2()' style='width:160px;margin-left:20px;'>";
    foreach($cube->DimensionUsage as $dimension)
    {
      $dimensionname=$dimension['name'];
      print "<option value='$dimensionname'>$dimensionname";
    }  
    print "</select>";
  }
}
  
    
  
?>
