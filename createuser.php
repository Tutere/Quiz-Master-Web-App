<?php

session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if (isset($username) && isset ($password)) {

    $sql = "SELECT * FROM users WHERE username = '$username'AND password = '$password'";

	$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['createAccountError'] = 'true';

    } else {

        $query = $conn->prepare("INSERT INTO `users`(`username`, `password`) 
        values (?,?)");
        $query->bind_param("ss",$username,$password);
        $query->execute();
    }
    $sql1 = "SELECT * FROM users WHERE username = '$username'AND password = '$password'";

	$result2 = $conn->query($sql);

    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    foreach ($result2 as $row) {
        $_SESSION['userid'] = $row['id'];
    }
           
    
}

header("Location: index.php");
?>