<?php //compose.php
	require_once "conn.php";
	$title="";
	$body="";
	$article="";
	$author_id="";
	if(isset($_GET["a"])
		and $_GET["a"] == "edit"
		and isset($_GET["article"])
		and $_GET["article"])
	{
		$sql = "SELECT title, body, author_id FROM cms_articles " .
		"WHERE article_id=" .$_GET["article"];
		$result = mysql_query($sql, $conn)
			or die("Couldn't retrieve article data: " . mysql_error());
		$row = mysql_fetch_array($result);
		$title = $row["title"];
		$body = $row["body"];
		$article = $_GET["article"];
		$author_id = $row["author_id"];
		mysql_close($conn);
	}
	require_once "header.php";
?>
<form method="post" action="transact-article.php">
	<h2>Compose Article</h2>

	<p>
		Title: <br/>
		<input type="text" class="title" name="title" maxlength="255" value="<?php echo htmlspecialchars($title); ?>"/>
	</p>
	<p>
		Body: <br/>
		<textarea class="body" name="body" rows="10" cols="60"><?php echo htmlspecialchars($body);?></textarea>
<!--CKEDIT-->
		<script type="text/javascript">
			CKEDITOR.replace("body");
		</script>
	</p>
	<p>
		<?php
			echo "<input type='hidden' name='article' value='" .
			$article . "\' />\n";
			if($_SESSION["access_lvl"] < 2)
			{
				echo "<input type='hidden' name='authorid' value='" .
				$author_id . "\' />";
			}
			if($article)
			{
				echo "<input type='submit' class='submit' name='action' " .
				"value=\"Save Changes\" />";
			}
			else
			{
				echo "<input type='submit' class='submit' name='action' " .
				"value=\"Submit New Article\" />";
			}
		?>
	</p>
</form>
<?php require_once "footer.php" ?>