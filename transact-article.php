<?php //transact-article.php
	session_start();
	require_once "conn.php";
	require_once "http.php";
	require_once "error_handler.php";

	if (isset($_REQUEST["action"])) 
	{
		switch ($_REQUEST["action"]) 
		{
			case "Submit New Article":
				if(isset($_POST["title"])
					and isset($_POST["body"])
						and isset($_SESSION["user_id"]))
					{
						$body = $_POST["body"];
						$tags = array("<p>", "</p>");
						$body = str_replace($tags, "", $body);
						$sql = "INSERT INTO cms_articles " .
						"(title,body,author_id,date_submitted) " .
						"VALUES ('" . $_POST["title"] .
						"','" . addslashes($body) .
						"'," . $_SESSION["user_id"] . ",'" .
						date("Y-m-d H:i:s", time()) . "')";
						mysql_query($sql,$conn)
							or die("Couldn't submit article: " . mysql_error());
					}
				redirect("index.php");
				break;
			case "Edit":
				redirect("compose.php?a=edit&article=" . $_POST["article"]);
				break;
			case "Save Changes":
				if(isset($_POST["title"])
					and isset($_POST["body"])
					and isset($_POST["article"]))
				{
					$body = $_POST["body"];
					$tags = array("<p>", "</p>");
					$body = str_replace($tags, "", $body);
					$sql = "UPDATE cms_articles " .
					"SET title='" . $_POST["title"] .
					"', body='" . addslashes($body) .
					"', date_submitted='" . date("Y-m-d H:i:s", time()) . "' " .
					"WHERE article_id=" . $_POST["article"];
					if(isset($_POST["authorid"])) 
					{
						$sql .= " AND author_id=" . $_POST["authorid"];
					}
					mysql_query($sql, $conn)
						or die("Couldn't update article: " . mysql_error());
				}
				if(isset($_POST["authorid"])) 
				{
					redirect("cpanel.php");
				}	
				else 
				{
					redirect("pending.php");
				}
				break;
			case "Publish":
				if($_POST["article"])
				{
					$sql = "UPDATE cms_articles " .
					"SET is_published = 1, date_published ='" .
					date("Y-m-d H:i:s",time()) . "' " .
					"WHERE article_id=" . $_POST["article"];
					mysql_query($sql, $conn)
						or die("Couldn't publish article: " . mysql_error());
				}
				redirect("pending.php");
				break;
			case "Retract":
				if($_POST["article"])
				{
					$sql = "UPDATE cms_articles " .
					"SET is_published = 0, date_published = ''" .
					"WHERE article_id=" . $_POST["article"];
					mysql_query($sql, $conn)
						or die("Couldn't retract article: " . mysql_error());
				}
				redirect("pending.php");
				break;
			case "Delete":
				if($_POST["article"])
				{
					$sql = "DELETE FROM cms_articles " .
					"WHERE is_published=0 " .
					"AND article_id=" . $_POST["article"];
					mysql_query($sql, $conn)
						or die("Couldn't delete article: " . mysql_error());
				}
				redirect("pending.php");
				break;
			case "Submit Comment":
				if(isset($_POST["article"])
					and $_POST["article"]
					and isset($_POST["comment"])
					and $_POST["comment"])
				{
					$sql = "INSERT INTO cms_comments " .
					"(article_id,comment_date,comment_user,comment) " .
					"VALUES (" . $_POST["article"] . ",'" .
					date("Y-m-d H:i:s", time()) .
					"'," . $_SESSION["user_id"] .
					",'" .$_POST["comment"] . "')";
					mysql_query($sql,$conn)
						or die("Couldn't add comment: " . mysql_error());
				}
				redirect("viewarticle.php?article=" . $_POST["article"]);
				break;
			case "Remove":
				if(isset($_GET["article"])
					and isset($_SESSION["user_id"]))
				{
					$sql = "DELETE FROM cms_articles " .
					"WHERE article_id=" . $_GET["article"] .
					" AND author_id=" . $_SESSION["user_id"];
					mysql_query($sql,$conn)
						or die("Couldn't remove article: " . mysql_error());
				}
				redirect("cpanel.php");
				break;
		}
		mysql_close($conn);
	} 
	else 
	{
		redirect("index.php");
	}
	?>