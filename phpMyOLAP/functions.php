<?php

function exec_query($query) {
//***************************************************Connection to DB
	global $db_host, $db_user, $db_password, $db_name;
	$db = mysql_connect($db_host, $db_user, $db_password);
	if ($db == FALSE) die ("Connection Error.<br>");
	mysql_select_db($db_name, $db) or die ("Error connecting to database.<br>");

	$result=mysql_query($query, $db);
	if(!$result) {
		print "QUERY: $query<br>"; 
		print mysql_error($db);
	}
	mysql_close($db);
	return $result;
}

function printLegend($img_cube,$img_mea,$img_dim,$img_hier,$img_lev,$img_prop) {
	global $message;
	print "<fieldset>";
	print "<legend>$message[legend]</legend><img src='$img_cube'> $message[cube] <img src='$img_mea'> $message[measure] <img src='$img_dim' width=24px height=24px>";
	print " $message[dimension] <img src='$img_hier'> $message[hier] <img src='$img_lev'> $message[lev] <img src='$img_prop'> $message[prop]";
	print " </fieldset>";
}

function printHTMLHead($stylefile,$jsfile,$redirectpage='') {
	print "<head>";
	if (strlen($redirectpage) != 0) {
		print "\n<meta http-equiv='refresh' content='0;URL=$redirectpage'/>\n";
		print "</head>";
		exit;
	}
	print "<link rel='stylesheet' type='text/css' href='$stylefile' />";
	print "<script type='text/javascript' src='$jsfile' language='javascript'></script>";
	print "<title>phpMyOLAP: $message[desc]</title>";
	print "</head>";
}

?>
