<?php 
session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");


$_SESSION['FromHomeOrSetPage'] = 'true';

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<title> Study Game </title>
		<link rel = "stylesheet" type  ="text/css" href= "style.css">
	</head>
	<body>

    <header id = "indexHeader">
			
			<div id="headerDiv1">

			<h1 id = "headerTitle"> Quiz Master </h1>

			<ul id="subMenu">

					<li> <a href="index.php">  Home </a></li>
					<li> <a href="">  About This Site </a></li>
					<li> <a href="createSet.php" id = "create">  Create Study Set </a></li>


				</ul>


			</div>

			<div id="headerDiv2">
			<?php
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

				?>
				<p id = "welcome">
                Welcome, <?=$_SESSION['username']?>!</p>

				<form action = "logout.php" method = "post">
					<input type="submit" value="Log out" id = "logout">
    			</form>
				<?php
			} elseif (isset($_SESSION['loginError']) && $_SESSION['loginError'] === 'true') {
				?>
				<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Log in</button>
				<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Create Account</button>

				<p> Sorry, that username and password combination does not exist.  </p>
				
				<?php
			} elseif (isset($_SESSION['createAccountError']) && $_SESSION['createAccountError'] === 'true') {
				?>
				<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Log in</button>
				<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Create Account</button>

				<p> Sorry, that username and password combination already exists.  </p>
				
				<?php
			} else {
			?>
			<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
			<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Create Account</button>

			<?php

			}
			?>
			</div>

		</header>

    <Main>
    
    <div id = "studySetMain">

    <h2>About this site</h2> 
    <div id = "about">
    <br>
    <p>Quiz Master aims to help people have fun while studying their topic of choice.
       This site firstly allows users to create study sets with cards that hold both a term
       and definition for later revision.
    </p>
    <p>
        Once study sets have been setup, users can then review their sets from the home page 
        and then elect to play a quiz game to help the new knowledge sink in.
    </p>
    <p>
        Note that users must have an account and be logged in to be able to review their sets later.
    </p>
    <br>

    <h2> Login Info</h2>
    <p>You can use the following details to view an account that is already setup with examples (or alternatively, create a new one):
        <br>
        <br>
        username: Tutere <br>
        Password: 123
    </p>
    
    </div>

   
</Main>
	<Script type="module" src="script.js"></Script>
	</body>
</html>