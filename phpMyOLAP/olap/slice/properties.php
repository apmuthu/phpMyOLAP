<?php

$dimensionname_sel=$_GET['dimension'];
$hiername_sel=$_GET['hier'];
$levelname_sel=$_GET['level'];

include("../../config.php");

$xml=simplexml_load_file($xmlfile);

print "<div style='margin-top:10px;'><b>Properties</b> of Level <i>$hiername_sel</i></div>";

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

            $imgdel="$urlsito/images/delete.png";
            print "<select id='prop' size=5 name='prop' onclick='selValore()' style='width:160px'>";
            foreach($level->Property as $prop)
            {
              $propname=$prop['name'];
              print "<option value='$propname'>$propname";    
            }  
            print "</select>";
                  
          
          }              
        }  
      }
    }      
  }
}

  
?>
