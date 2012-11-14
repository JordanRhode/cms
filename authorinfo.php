<?php //authorinfo.php

	require_once "header.php";
	require_once "conn.php";

	if(isset($_GET["author"])){

		$sql = "SELECT *" .
		"FROM cms_users " .
		"WHERE name='" . $_GET["author"] . "'";
		$result = mysql_query($sql, $conn)
		or die("Couldn't look up author data: " . mysql_error());
		$author = mysql_fetch_array($result);
		mysql_close($conn);
		echo "<br/><h3>Author Info</h3>";
		echo "Name: " . $author["name"] . "<br/>";
		echo "Email: " . $author["email"] . "<br/>";
		echo "Age: " . $author["age"] . "<br/>";
		echo "Hometown: " . $author["hometown"] . "<br/>";
		echo "Bio: " . $author["bio"] . "<br/>";
	}

	require_once "footer.php" ?>