<?php 
session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");


if (isset($_REQUEST['mode'])) {
   $mode = $_REQUEST['mode']; 
} else {
    $mode = $_SESSION['mode'];
}

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
    <div>
        <button id = "playQuiz"> Play Quiz Game</button>
        <button id = "stopButton"> Stop Quiz Game</button>
    <div>
    <div id = "studySetMain">

    <h2>Study Set Title: 
		<?php echo $mode;?>
    </h2>    

    <?php
            if ($mode) {
			$query = $conn->prepare("SELECT * FROM `studySets` WHERE studySetMode = ? AND userid = ?");
            $query->bind_param("si", $mode,$_SESSION['userid']);
			$query->execute();
			$result = $query->get_result();


    ?>
            <table class = "studySetTable" id = "studyTable">
    <?php
			foreach ($result as $row) {
			
	?>		
            <tr>
			<td id = "firstColumn" class = "studySetTD"><?php echo $row['question']?></td>
            <td id = "secondColumn" class = "studySetTD"><?php echo $row['answer']?></td>
            <td id = "deleteColumn" class = "studySetTD">
                
                <form action="deleteRecord.php" method = "post">
                    <input type="hidden" value ="<?= $row['studySet']?>" name = "Title">
                    <input type="hidden" value ="<?= $row['question']?>" name = "Term">
                    <input type="hidden" value ="<?= $row['answer']?>" name = "Definition">
                    <input type="submit" value ="Delete Item" id="deleteButton" >
                </form>
        
            </td>
			</tr>

	<?php
            }

		}
	?>

            </table>
    

    <h2>Add More Study Terms: </h2>
    
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
        <input type = "hidden" value = "<?= $mode ?>" name = "Title"></input>
        <input type = "hidden" value = "true" name = "studyPage"></input>
        <input type="submit" value = "Add New Term"id ="createSetSubmit"> </input>
        </div>
    </div>
    </form>

    <br>
    <form action="deleteRecord.php" method = "post" >
        <input type="hidden" value ="<?= $mode ?>" name = "Title">
         <input type="hidden" value = "true" name = "deleteSet">
        <input type="submit" value ="Delete Entire Study Set" id = "deleteRecord">
    </form>
	</div>
    <br>
    <br>

<!-- ******REFERENCE*******
used following tutorial to give outline for quiz container*********
https://www.youtube.com/watch?v=riDzcEQbX6k&ab_channel=WebDevSimplified -->
    
    <div class="Quizcontainer", id = "QuizContain">
    <div id="question-container" class="hide">
      <div id="question">Question</div>
      <div id="answer-buttons" class="btn-grid">
        <button class="btn">Answer 1</button>
        <button class="btn">Answer 2</button>
        <button class="btn">Answer 3</button>
        <button class="btn">Answer 4</button>
      </div>
    </div>
    <div class="controls">
    <?php
            $_SESSION['Title'] = $mode;
        ?>
      <button id="StartB2" class="StartB2 btn" class >Start</button>
      <button id="nextQButton" class="nextQButton btn hide">Next</button>
    </div>
  </div>
</Main>
	<Script type="module" src="script.js"></Script>
	</body>
</html>