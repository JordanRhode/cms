<?php //useraccount.php
	require_once "conn.php";
	$userid = "";
	$name = "";
	$email = "";
	$password = "";
	$access_lvl = "";
	$hometown = "";
	$age = "";
	$bio = "";
	$create = false;

	if(isset($_GET["userid"])) {
		$sql = "SELECT * FROM cms_users WHERE user_id=" . $_GET["userid"];
		$result = mysql_query($sql,$conn)
			or die("Couldn't look up user data: " . mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $_GET["userid"];
		$name = $row["name"];
		$email = $row["email"];
		$access_lvl = $row["access_lvl"];
		$hometown = $row["hometown"];
		$age = $row["age"];
		$bio = $row["bio"];
	}
	require_once "header.php";
	echo "<form method=\"post\" action=\"transact-user.php\">\n";
	if($userid) {
		echo "<h1>Modify Account</h1>\n";
		$create = false;
	}	else {
		echo "<h1>Create Account</h1>\n";
		$create = true;
	}
?>
<p>
	Full name: <br/>
	<input type="text" class="textInput" name="name" maxlength="100" value="<?php echo htmlspecialchars($name);?>" />
</p>
<p>
	Email Address: <br/>
	<input type="text" class="textInput" name="email" maxlength="255" value="<?php echo htmlspecialchars($email);?>" />
</p>
<?php if($cerate == true){?>
<p>
	Age: <br/>
	<input type="text" class="textInput" name="age" maxlength="3" value="<?php echo htmlspecialchars($age);?>" />
</p>
<p>
	Hometown: <br/>
	<input type="text" class="textInput" name="hometown" maxlength="255" value="<?php echo htmlspecialchars($hometown);?>" />
</p>
<p>
	Bio(500 char max): <br/>
	<textarea name="bio" class="textarea" rows="4" cols="50" maxlength="500"></textarea>
</p>
<?php } ?>
<?php
	if(isset($_SESSION["access_lvl"])
		and $_SESSION["access_lvl"] == 3)
	{
		echo "<fieldset>\n";
		echo "<legend>Access Level</legend>\n";
		$sql = "SELECT * FROM cms_access_levels ORDER BY access_lvl DESC";
		$result = mysql_query($sql, $conn)
			or die("Couldn't list access levels: " . mysql_error());
		while ($row = mysql_fetch_array($result)) {
			echo ' <input type="radio" class="radio" id="acl_' .
			$row["access_lvl"] . '" name="access_lvl" value="' .
			$row["access_lvl"] . '" ';
			if($row["access_lvl"] == $access_lvl) {
				echo "checked='checked'";
			}
			echo ">" . $row["access_name"] . "<br/>\n";
		}
?>
</fieldset>
<p>
	<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
	<input type="submit" class="submit" name="action" value="Modify Account" />
</p>
<?php } else { ?>
<p>
	Password: <br/>
	<input type="password" id="password" name="password" maxlenght="50" />
</p>
<p>
	Password (again): <br/>
	<input type="password" id="password2" name="password2" maxlenght="50" />
</p>
<p>
	<input type="submit" class="submit" name="action" value="Create Account" />
</p>
<?php } ?>
</form>
<?php
	mysql_close($conn);
    require_once "footer.php"; ?>