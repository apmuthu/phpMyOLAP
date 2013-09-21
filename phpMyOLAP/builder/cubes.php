<?php


include_once("../config.php");
include_once("views/views.php");


$xml=simplexml_load_file($xmlfile);

foreach($xml->Cube as $cube)
{
  $cubename=$cube['name'];
  printCube($cubename,$img_cube);    
}

    
  
?>
