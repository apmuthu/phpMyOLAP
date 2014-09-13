<?php

function exec_query($query)
{
//***************************************************Connection to DB
global $db_host, $db_user, $db_password, $db_name;
$db = mysql_connect($db_host, $db_user, $db_password);
if ($db == FALSE) die ("Connection Error.<br>");
mysql_select_db($db_name, $db) or die ("Error connecting to database.<br>");

 
$result=mysql_query($query, $db);
if(!$result)
{
print "QUERY: $query<br>"; 
print mysql_error($db);
}

mysql_close($db);

return $result;
}



function printLegend($img_cube,$img_mea,$img_dim,$img_hier,$img_lev,$img_prop)
{
print "<fieldset>";
print "<legend>Legenda</legend><img src='$img_cube'> Cube <img src='$img_mea'> Measure <img src='$img_dim' width=24px height=24px>";
print " Field <img src='$img_hier'> Hierarchy <img src='$img_lev'> Level <img src='$img_prop'> Properties";
print " </fieldset>";

}

function printHTMLHead($stylefile,$jsfile)
{
print "<head>";
print "<link rel='stylesheet' type='text/css' href='$stylefile' />";
print "<script type='text/javascript' src='$jsfile' language='javascript'></script>";
print "<title>phpMyOLAP: OLAP tool for MySQL databases</title>";
print "</head>";
}

?>
