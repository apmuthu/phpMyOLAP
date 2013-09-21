<?php

$cubename=$_GET['cube'];
$measurename=$_GET['measure'];

include("../config.php");
include("aggregate_functions.php");
include("views/views.php");

$xml=simplexml_load_file($xmlfile);

foreach($xml->Cube as $cube)
{
  $cubename2=$cube['name'];
  if($cubename2==$cubename)
  {
  foreach($cube->Measure as $measure)
  {
  $measurename2=$measure["name"];
  if($measurename2==$measurename)
    $measurecol=$measure["column"];    
  }
  }
}


$n=count($function);
for($i=0;$i<$n;$i++)
{
$aggregate="$function[$i]($measurename)";
printAggFunct($aggregate,$img_lastlink,$img_mea,$img_del,$img_link);

}
  
  
  
  
?>
