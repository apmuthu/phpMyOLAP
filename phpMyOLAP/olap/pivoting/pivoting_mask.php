<?php

print "<div id='divPivoting' style='z-index:300; visibility:hidden;background-color: white; width:500px; height:250px; border: 2px grey solid;position:absolute;top:100px;left:350px;margin-left:15px;margin-top:15px'>";
print "<div style='margin-top:15px;margin-left:15px;'>";

print "<form action='pivoting/pivoting.php' name='form_pivoting' method=post target='_blank'>";
print "<input type=hidden name='cubename' value='$cubename_sel'>";
print "<input type=hidden name='slice_pivoting' id='slice_pivoting' value=''>";

print "Cubo: <b>$cubename_sel</b><br>";
$num_lev_p=count($levels);
print "Seleziona una misura:<br>";

print "<select name=measure_p>";
for($i=0;$i<$num_lev_p;$i++)
{
    list($dim_p,$hier_p,$lev_p,$prop_p)=explode(".",$levels[$i]);
    $measure_p="$prop_p";
    if($dim_p=="cube" and $hier_p=="cube")
      print "<option value='$levels[$i]'>$measure_p";
}
print "</select>";


print "<table>";
print "<tr>";

print "<td>";
print "Sulle colonne<br>";
print "<select size=5  id='cols_pivoting' name='cols_pivoting' style='width:200px'>";
for($i=0;$i<$num_lev_p;$i++)
{
    list($dim_p,$hier_p,$lev_p,$prop_p)=explode(".",$levels[$i]);
    //$field_p="$lev_p.$prop_p";
    $field_p="$dim_p.$hier_p.$lev_p";
    $is_id=checkLevelId($cubename_sel,$dim_p,$hier_p,$lev_p,$prop_p);
    if($dim_p!="cube" and $hier_p!="cube" and $is_id==true)
      print "<option value='$levels[$i]'>$field_p";
}
print "</select>";
print "</td>";

print "<td>";
print "<input type=button value='->' onclick='toRows()'><br>";
print "<input type=button value='<-' onclick='toCols()'>";
print "</td>";


print "<td>";
print "Sulle righe<br>";
print "<select size=5  id='rows_pivoting' name='rows_pivoting' style='width:200px'>";
print "</select>";
print "<td>";

print "</tr>";
print "</table>";



print "<center>";
print "<table>";
print "<tr>";
print "<td>";
print "<a style='width:120px' class='button' href='#' onclick=\"exec_pivoting()\">OK</a>";
print "</td>";
print "<td>";
print "<a style='width:120px' class='button' href='#' onclick=\"document.getElementById('divPivoting').style.visibility='hidden';\">Chiudi</a>";
print "</td>";
print "<tr>";
print "</table>";
print "</center>";

print "</form>";

print "</div>";
print "</div>";

function checkLevelId($cubename_p,$dim1,$hier1,$lev1,$prop1)
{

global $xmlfile;
$xml=simplexml_load_file($xmlfile);

foreach($xml->Cube as $cube)
  {
    //print "OK<br>";
    $cubename=(string) $cube['name'];
    //print "CU $cubename<br>";
    if($cubename==$cubename_p)
    {
      //print "CU FOUND $cubename_p<br>";
      foreach($cube->DimensionUsage as $dimension)
      {
        $dimensionname=(string) $dimension['name'];
        if($dimensionname==$dim1) 
        {
          //print "D FOUND1 $dim1<br>";
          foreach($xml->Dimension as $dimensioncube)
          {
              $dimensionname2=(string) $dimensioncube['name'];
              if($dimensionname2==$dim1)
              {
                //print "D FOUND2 $dim1<br>";
                foreach($dimensioncube->Hierarchy as $hier)
                {      
                    $hiername=(string) $hier['name'];
                    $pk_hiertable=$hier['primaryKeyTable'];
                    if($hiername==$hier1)
                    {
                       //print "H FOUND $hier1<br>";
                       foreach($hier->Level as $level)
                       {
                          $levelname=(string) $level['name'];
                          $level_col=(string) $level['column'];
                          if($levelname==$lev1)
                          {                                                                        
                            foreach($level->Property as $prop)
                            {
                              $propname=(string) $prop['name'];
                              if($propname==$prop1)
                              {
                                $prop_col=(string) $prop['column'];
                                if($prop_col==$level_col) return true;
                          
                              }             
                            }
                          }
                       }
                    }
                }
              }
          }
        }
      }      
    }
  }



}

?>
