<?php //search.php
	require_once "conn.php";
	require_once "outputfunctions.php";
	require_once "header.php";
	$result = NULL;
	if(isset($_GET["keywords"])) {
		$sql = "SELECT article_id FROM cms_articles " .
		"WHERE MATCH (title,body) " .
		"AGAINST ('" . $_GET["keywords"] . "' IN BOOLEAN MODE) " .
		"ORDER BY MATCH (title,body) " .
		"AGAINST ('" . $_GET["keywords"] . "' IN BOOLEAN MODE) DESC";
		$result = mysql_query($sql,$conn)
			or die("Couldn't perform search: " . mysql_error());
	}
	echo "<h1>Search Results</h1>";
	if($result and !mysql_num_rows($result)) {
		echo "<p>No articles found that match the terms.</p>\n";
	}	else {
		while ($row = mysql_fetch_array($result)) {
			outputStory($row["article_id"], TRUE);
		}
	}
	mysql_close($conn);
	require_once "footer.php";
?>