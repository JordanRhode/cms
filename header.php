<?php //header.php
	session_start();  
?>

<!--
	I learned a lot with this assignment, I didn't struggle very much with it, the tutorial was pretty straight forward. 
	The extra items that I added are:
	1-revise password to use salt
	2-Design the CMS using CSS
	3-Replace plain text box with CKEDIT
	4-Add ability for users to enter extra fields and provide link to author information
	5-Close connection to DB

	my default user is rhode.jordan@gmail.com with password of temp. 
	You can just create your own user.
	-->

<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<LINK href="assets/css/styles.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>

<html>
	<head>
		<title>Comic Book Appreciatoin</title>
	</head>

	<body>
		<div id="container">
		<div id="header">
		<div id="logonbar">
			<div id="logoblob">
				<h1>Comic Book Appreciation</h1>
			</div>
			<?php
				//if $_SESSION["name"] is false, we know the user is not logged in
				if (isset($_SESSION["name"])) 
				{
					echo " <div id='logowelcome'>";
					echo " Currently logged in as: " . $_SESSION['name'];
					echo " </div>";
				}
			?>	
		</div>
		<div id="navright">
			<form method="get" action="search.php">
				<p>
					<input id="searchkeywords" type="text" name="keywords"
					<?php
						if(isset($_GET["keywords"]))
						{
							//if there are keywords, they'll be displayed in the search box
							echo "value='" . htmlspecialchars($_GET["keywords"]) . "'";
						}
					?>
					/>
					<input id="searchbutton" class="submit" type="submit" value="search" />
				</p>
			</form>
		</div>
	</div>
		<div id="maincolumn">
			<div id="navigation">
				<?php
					echo "<a href='index.php'>Articles</a>";
					if(!isset($_SESSION["user_id"])) 
					{
						echo " | <a href='login.php'>Login</a>";
					} else {
						echo " | <a href='compose.php'>Compose Article</a>";
						if ($_SESSION["access_lvl"] > 1) 
						{
							echo " | <a href='pending.php'>Review</a>";
						}
						if ($_SESSION["access_lvl"] > 2) 
						{
							echo " | <a href='admin.php'>Admin</a>";
						}
						echo " | <a href='cpanel.php'>Control Panel</a>";
						echo " | <a href='transact-user.php?action=Logout'>Logout</a>";
					}
				?>
			</div>
			<div id="articles">