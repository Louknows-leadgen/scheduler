<?
$con = mysql_connect("localhost","digicono_HRadmin","DigiC0n0nlin3!");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("internal", $con);
?>