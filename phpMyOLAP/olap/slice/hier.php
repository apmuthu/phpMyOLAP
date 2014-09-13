<?php

$dimensionname_sel=$_GET['dimension'];

include("../../config.php");

$xml=simplexml_load_file($xmlfile);

print "<div style='margin-top:10px;'><b>Hierarchy</b> in the Dimension <i>$dimensionname_sel</i></div>";


foreach($xml->Dimension as $dimension)
{
  $dimensionname=$dimension['name'];
  if($dimensionname==$dimensionname_sel)
  {
    print "<select id='hier' size=5 name='hier' onclick='discoverLev2()' style='width:160px'>";
    foreach($dimension->Hierarchy as $hier)
    {
      $hiername=$hier['name'];
      print "<option value='$hiername'>$hiername";    
    }  
    print "</select>";
  }
}

  
?>
