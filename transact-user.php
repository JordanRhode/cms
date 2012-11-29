<?php //transact-user.php
	require_once "conn.php";
	require_once "http.php";
	require_once "error_handler.php";

	$salt = "abcdefg";
	if(isset($_REQUEST["action"]))
	{
		switch ($_REQUEST["action"]) {
			
			case "Login":
				if(isset($_POST["email"])
					and isset($_POST["password"]))
				{
					$password = sha1($_POST["password"] . $salt);
			
					$sql = "SELECT user_id, access_lvl, name " .
					"FROM cms_users " .
					"WHERE email='" . $_POST["email"] . "' " .
					"AND password='" . $password . "'";
					$result = mysql_query($sql,$conn)
						or die("Couldn't look up user information: " . mysql_error());
					if($row = mysql_fetch_array($result))
					{
						session_start();
						$_SESSION["user_id"] = $row["user_id"];
						$_SESSION["access_lvl"] = $row["access_lvl"];
						$_SESSION["name"] = $row["name"];
					}

				}
				redirect("index.php");
				break;
			case "Logout":
				session_start();
				session_unset();
				session_destroy();
				redirect("index.php");
				break;
			case "Create Account":
				if(isset($_POST["name"])
					and isset($_POST["email"])
					and isset($_POST["password"])
					and isset($_POST["password2"])
					and ($_POST["password"]) == $_POST["password2"])
				{
					$password = sha1($_POST["password"] . $salt);

					$sql = "INSERT INTO cms_users (email,name,password,hometown,age,bio) " .
						"VALUES ('" . $_POST["email"] . "','" .
						$_POST["name"] . "','" . $password . "','" . $_POST["hometown"] . "','" . $_POST["age"] . "','" . $_POST["bio"] . "')";
					mysql_query($sql,$conn)
						or die("Couldn't create user account: " . mysql_error());
						session_start();
						$_SESSION["user_id"] = mysql_insert_id($conn);
						$_SESSION["access_lvl"] = 1;
						$_SESSION["name"] = $_POST["name"];
				}
				redirect("index.php");
				break;
			case "Modify Account":
				if(isset($_POST["name"])
					and isset($_POST["email"])
					and isset($_POST["access_lvl"])
					and isset($_POST["userid"]))
				{
					$sql = "UPDATE cms_users " .
					"SET email='" . $_POST['email'] .
					"', name='" . $_POST['name'] .
					"', access_lvl=" . $_POST['access_lvl'] . " " .
					"WHERE user_id=" . $_POST['userid'];
					mysql_query($sql,$conn)
						or die("Couldn't update user account: " . mysql_error());
				}
				redirect("admin.php");
				break;
			case "Send my reminder":
				if(isset($_POST["email"]))
				{
					$sql = "SELECT password FROM cms_users " .
					"WHERE email='" . $_POST["email"] . "'";
					$result = mysql_query($sql,$conn)
						or die("Couldn't look up password: " . mysql_error());
					if(mysql_num_rows($result))
					{
						$row = mysql_fetch_array($result);
						$subject = "Comic site password reminder";
						$body = "Just a reminder that your password for the Comic Book Appreciation site is: " .
						$row["password"] .
						"\n\nYou can use this log in at http://" .
						$_SERVER["HTTP_HOST"] .
						dirname($_SERVER["PHP_SELF"]) . "/";
						mail($_POST["email"], $subject, $body)
							or die("Couldn't send reminder email.");
					}
				}
				redirect("login.php");
				break;
			case "Change my info":
				session_start();
				if(isset($_POST["name"])
					and isset($_SESSION["user_id"]))
				{
					$sql = "UPDATE cms_users " .
						"SET email='" . $_POST["email"] .
						"', name='" . $_POST["name"] .
						"', age='" . $_POST["age"] .
						"', hometown='" . $_POST["hometown"] .
						"', bio='" . $_POST["bio"] . "' " .
						"WHERE user_id=" . $_SESSION["user_id"];
					mysql_query($sql,$conn)
						or die("Couldn't update your user account: " . mysql_error());
				}
				redirect("cpanel.php");
				break;
		}
		mysql_close($conn);
	}
?>