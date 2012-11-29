<?php //conn.php
	define("SQL_HOST", "localhost");
	define("SQL_USER", "root");
	define("SQL_PASS", "");
	define("SQL_DB", "cms_site");
	$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS);
	mysql_select_db(SQL_DB, $conn) or 
		catch_error();

	function catch_error()
	{
		error_log("Error: Could not select the database: " . mysql_error() .
			"\n" , 3, "debug.log");
			die("Couldn't select the database: " . mysql_error()); 
	}
?>