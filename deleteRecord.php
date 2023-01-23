<?php
session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");

$term = $_REQUEST['Term'];
$definition = $_REQUEST['Definition'];
$title = $_REQUEST['Title'];
$deleteSet = $_REQUEST['deleteSet'];

$_SESSION['FromHomeOrSetPage'] = 'false';


if ($deleteSet == 'true') {
    $query2 = $conn->prepare("DELETE FROM `studySets` WHERE studySet = ? AND userid = ?");
    $query2->bind_param("si",$title,$_SESSION['userid']);
    $query2->execute();
    header("Location: index.php");
} else {

$query2 = $conn->prepare("DELETE FROM `studySets` WHERE question = ? AND answer = ? AND 
studySet = ? AND userid = ?");
$query2->bind_param("sssi",$term,$definition,$title,$_SESSION['userid']);
$query2->execute();
 echo "success";


$_SESSION['mode'] = $title;

header("Location: studySetPage.php");

}
?>
