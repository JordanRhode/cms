<?php
	require_once "conn.php";
	require_once "header.php";
	$sql = "SELECT name, email, age, hometown, bio " .
	"FROM cms_users " .
	"WHERE user_id=" . $_SESSION["user_id"];
	$result = mysql_query($sql, $conn)
		or die("Couldn't look up user data: " . mysql_error());
	$user = mysql_fetch_array($result);
?>
<form method="post" action="transact-user.php">
	<p>
		Name: <br/>
		<input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>"/>
	</p>
	<p>
		Email <br/>
		<input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>"/>
	</p>
	<p>
	Age: <br/>
	<input type="text" class="textInput" name="age" maxlength="3" value="<?php echo htmlspecialchars($user["age"]);?>" />
	</p>
	<p>
	Hometown: <br/>
	<input type="text" class="textInput" name="hometown" maxlength="255" value="<?php echo htmlspecialchars($user["hometown"]);?>" />
	</p>
	<p>
	Bio(500 char max): <br/>
	<textarea name="bio" class="textarea" rows="4" cols="50" maxlength="500"><?php echo htmlspecialchars($user["bio"]); ?></textarea>
	</p>
	<p>
		<input type="submit" class="submit" name="action" value="Change my info" />
	</p>
</form>
<h1>Pending Articles</h1>
<div class="scroller">
	<table>
<?php
	$sql = "SELECT article_id, title, date_submitted " .
	"FROM cms_articles " .
	"WHERE is_published=0 " .
	"AND author_id=" . $_SESSION["user_id"] . " " .
	"ORDER BY date_submitted";
	$result = mysql_query($sql, $conn)
		or die("Couldn't get list of pending articles: " . mysql_error());
	if(mysql_num_rows($result) == 0) {
		echo "<em>There are no pending articles</em>.";
	}	else {
		while($row=mysql_fetch_array($result)) {
			echo "<tr>\n";
			echo "<td><a href='reviewarticle.php?article=" .
			$row["article_id"] . "'>" . htmlspecialchars($row["title"]) .
			"</a> (Submitted " .
				date("F j, Y", strtotime($row["date_submitted"])) .
				")</td>\n";
			echo "</tr>\n";
		}
	}
?>
</table>
</div>
<br/>
<h2>Published Stories</h2>
<div class="scroller">
	<table>
		<?php
			$sql = "SELECT article_id, title, date_published " .
			"FROM cms_articles " .
			"WHERE is_published=1 " .
			"AND author_id=" . $_SESSION["user_id"] . " " .
			"ORDER BY date_submitted";
			$result = mysql_query($sql, $conn)
				or die("Couldn't get list of published articles: " . mysql_error());
			if(mysql_num_rows($result) == 0) {
				echo "<em>There are no published articles</em>.";
			}	else {
				while($row=mysql_fetch_array($result)) {
					echo "<tr>\n";
					echo "<td><a href='viewarticle.php?article=" .
					$row["article_id"] . "'>" . htmlspecialchars($row["title"]) .
					"</a> (published " .
						date("F j, Y", strtotime($row["date_published"])) .
						")</td>\n";
					echo "</tr>\n";
				}
			}
		?>
	</table>
</div>
<br/>
<?php 
mysql_close($conn);
require_once "footer.php" ?>