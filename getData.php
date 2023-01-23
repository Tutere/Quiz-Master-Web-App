<?php

session_start();

$userid = $_SESSION['userid'];
$title = $_SESSION['Title'];

$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");
$sql = "SELECT * FROM `studySets` WHERE studySet = '$title' AND userid ='$userid'";
$result = $conn->query($sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data [] = $row;
}
echo json_encode($data);
