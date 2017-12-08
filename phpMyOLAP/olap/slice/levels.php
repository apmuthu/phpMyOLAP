<?php

$dimensionname_sel=$_GET['dimension'];
$hiername_sel=$_GET['hier'];

include("../../config.php");

$xml=simplexml_load_file($xmlfile);

print "<div style='margin-top:10px;'>Hierarchy <b>Levels</b> in <i>$hiername_sel</i></div>";

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
        print "<select id='level' size=5 name='level' onclick='discoverProp2()' style='width:160px'>";
        foreach($hier->Level as $level)
        {
          $levelname=$level['name'];
          print "<option value='$levelname'>$levelname";    
        }  
        print "</select>";
      }
    }      
  }
}

  
?>
