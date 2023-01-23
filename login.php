<?php

session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if (isset($username) && isset ($password)) {

    $sql = "SELECT * FROM users WHERE username = '$username'AND password = '$password'";

	$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        foreach ($result as $row) {
            $_SESSION['userid'] = $row['id'];
        }

        echo $_SESSION['userid'];
    } else {
        $_SESSION['loginError'] = 'true';
        echo "no match";
    }
    
}


header("Location: index.php");
?>