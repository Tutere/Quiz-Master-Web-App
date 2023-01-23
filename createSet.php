<?php 
session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");

if($_SESSION['FromHomeOrSetPage'] == 'true') {
    $_SESSION['Title'] = '';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<title> Create a new study set </title>
		<link rel = "stylesheet" type  ="text/css" href= "style.css">
	</head>
	<body>

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

    <div id = "createMain">
    <?php
        if($_SESSION['Duplicate'] == 'true') {
            ?>
            <h2>Sorry, that title is already being used for another study set! Please enter a new title.</h2>
            <?php
        } 
    ?>

    <h2>Study Set Title: <?php
			if (isset($_SESSION ['Title'])) {
				echo $_SESSION['Title']
                
            ;}?>
    </h2>    

    <form action="insertRecord.php" method = "post">

        <?php
            if ($_SESSION['Title'] == '') {
                ?>
                <input id = "setTitle" value = "<?php echo $_SESSION ['Title']?>" name = "Title">  </input>
       

        <?php
            } else {
                ?>
                <input type = "hidden" value = "<?php echo $_SESSION ['Title']?>" name = "Title"></input>
    
            <?php
            $_SESSION["Hidden"] = 'true';
            }
        ?>

    <div>

        <?php
            if (isset($_SESSION ['Title'])) {
			$query = $conn->prepare("SELECT * FROM `studySets` WHERE studySet = ?;");
            $query->bind_param("s", $_SESSION['Title']);
			$query->execute();
			$result = $query->get_result();
    ?>
            <table class="createSetTable" id = "createTable">
    <?php
			foreach ($result as $row) {
			
	?>		
            <tr>
			<td id = "firstColumn" class = "createtTD"><?php echo $row['question']?></td>
            <td id = "secondColumn" class = "createtTD"><?php echo $row['answer']?></td>
            
			</tr>

	<?php
            }

		}
	?>

            </table>


    <h2>Insert Study Terms</h2>
    
    <div class = "setDivs">
    <form action="insertRecord.php" method = "post" class = "addTermsForm">
        <div>
            <label for="Term"> Term</label>
            <input type="text" name="Term"> </input>
        </div>
        <div>
            <label for="Definition">Definition</label>
            <input type="text" name="Definition"> </input>
        </div>
        <div class = "submitTerm">
        <a href=""></a>
        <input type = "hidden" value = "false" name = "studyPage"></input>
        <input type="submit" value = "Add New Term"id ="createSetSubmit"> </input>
        </div>
    </div>
    <br>
    <br>
    <br>

    <a href="index.php" id = "backToHomePage"> Back To Homepage </a>
</div>

    </Main>
	<Script type="module" src="script.js"></Script>
	</body>
</html>