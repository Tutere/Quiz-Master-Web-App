<?php 
session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");
$mode = 'test';
$_SESSION['Title'] = '';
$_SESSION['Duplicate'] = 'false'; 
$_SESSION["Hidden"] = 'false';
$userid = 0;

$_SESSION['FromHomeOrSetPage'] = 'true';

if (isset($_REQUEST['mode']))
	$mode = $_REQUEST['mode'];

if (isset($_SESSION['userid'])) {
	$userid = $_SESSION['userid'];
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<title> Study Game </title>
		<link rel = "stylesheet" type  ="text/css" href= "style.css">
	</head>
	<body id = "indexBody">

		<header id = "indexHeader">
			
			<div id="headerDiv1">

			<h1 id = "headerTitle"> Quiz Master </h1>

			<ul id="subMenu">

					<li> <a href="index.php">  Home </a></li>
					<li> <a href="About.php">  About This Site </a></li>
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
					<input type="submit" value="Log out" id="logout">
    			</form>
				<?php
			} elseif (isset($_SESSION['loginError']) && $_SESSION['loginError'] === 'true') {
				?>
				<button onclick="document.getElementById('loginModal').style.display='block'" style="width:auto;">Log in</button>
				<button onclick="document.getElementById('createAccModal').style.display='block'" style="width:auto;">Create Account</button>

				<p> Sorry, that username and password combination does not exist.  </p>
				
				<?php
			} elseif (isset($_SESSION['createAccountError']) && $_SESSION['createAccountError'] === 'true') {
				?>
				<button onclick="document.getElementById('loginModal').style.display='block'" style="width:auto;">Log in</button>
				<button onclick="document.getElementById('createAccModal').style.display='block'" style="width:auto;">Create Account</button>

				<p> Sorry, that username and password combination already exists.  </p>
				
				<?php
			} else {
			?>
			<button onclick="document.getElementById('loginModal').style.display='block'" style="width:auto;">Login</button>
			<button onclick="document.getElementById('createAccModal').style.display='block'" style="width:auto;">Create Account</button>

			<?php

			}
			?>
			</div>
		

		</header>

        <Main>
		<h1 id = "studySetsHeading">
		<strong>Your Study Sets</strong>
		</h1>
		<div id = "studySets">

			<?php
			$result = $conn->query("SELECT DISTINCT studySet FROM studySets WHERE userid = '$userid';");
			foreach ($result as $row) {
			?>
			

			<div class = "studySet" id = <?php echo str_replace(' ', '',$row['studySet'])?> >
				<h3> <?php echo$row['studySet']?> </h3>
				<br>
				
				

				
				<form action = "studySetPage.php" method = "get">
					<input type = "hidden" value="<?= $row['studySet']?>" name= "mode">

					<a href="studySetPage.php?mode=<?= $row['studySet']?>">
					<input type="submit" value = "View Study Set" id = "viewStudySetButton">
					</a>
				</form>
				</a>
			</div>

			<?php

			}
			?>

		</div>

		</Main>





<!-- ******REFERENCE*****
Used the following site for guidance on how to create a pop up login form:
https://www.w3schools.com/howto/howto_css_login_form.asp -->


<!-- /********login */ -->

<div id="loginModal" class="modal">
  
  <form class="modal-content animate" action="login.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('loginModal').style.display='none'" 
	  class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Log in</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('loginModal').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>


<!-- /********create account */ -->

<div id="createAccModal" class="modal">
  
  <form class="modal-content animate" action="createuser.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('createAccModal').style.display='none'" 
	  class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Create Account</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('createAccModal').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>


	<Script type="module" src="script.js"></Script>
	</body>
</html>