<?php

$cubename=$_GET['cube'];

include("../config.php");
include("views/views.php");


$xml=simplexml_load_file($xmlfile);

printTree($cubename,$img_cube,$img_plus);

  
?>
