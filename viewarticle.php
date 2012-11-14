<?php //viewarticle.php
	require_once "conn.php";
	require_once "outputfunctions.php";
	require_once "header.php";
	outputStory($_GET["article"]);
	showComments($_GET["article"], TRUE);
	mysql_close($conn);
	require_once "footer.php";
?>