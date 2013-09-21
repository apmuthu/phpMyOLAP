<?php


include_once("../config.php");
include_once("views/views.php");

if($operazione=="back")
{
  $cubename_sel=$_POST['cubename'];
  $levels=unserialize(stripslashes($_POST['levels']));
  restore($cubename_sel,$levels,$img_del);
}      
  
?>
