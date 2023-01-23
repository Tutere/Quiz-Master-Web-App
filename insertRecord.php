<?php
session_start();
$conn = new mysqli("localhost", "myuser", "mypass", "studyGame");

$term = $_REQUEST['Term'];
$definition = $_REQUEST['Definition'];
$title = $_REQUEST['Title'];
$studyPage = $_REQUEST['studyPage'];

$_SESSION['FromHomeOrSetPage'] = 'false';

if ($studyPage == 'true') {
    $query = $conn->prepare("INSERT INTO `studySets`(`question`, `answer`, `studySet`, `studySetMode`, `userid`) 
        values (?,?,?,?,?)");
    $query->bind_param("ssssi",$term,$definition,$title,$title,$_SESSION['userid']);
    $query->execute();
    $_SESSION['mode'] = $title;
    header("Location: studySetPage.php");
} else {

//check to see if name given for study set already exists
$query1 = $conn->prepare("SELECT DISTINCT studySet from studySets WHERE studySet = ? AND userid = ? ");
$query1->bind_param("si",$title, $_SESSION['userid']);
$query1->execute();
$result = $query1->get_result();
$helper = '';

foreach ($result as $row) {
    $helper = $row['studySet'];
}

if ($helper != '' && $_SESSION['Hidden'] != 'true') {
    $_SESSION['Duplicate'] = 'true';
    header("Location: createSet.php");
} else {
    $_SESSION['Duplicate'] = 'false';


    $query2 = $conn->prepare("INSERT INTO `studySets`(`question`, `answer`, `studySet`, `studySetMode`, `userid`) 
        values (?,?,?,?,?)");
    $query2->bind_param("ssssi",$term,$definition,$title,$title,$_SESSION['userid']);
    $query2->execute();
    echo "success";

    if(isset($title)) {
        $_SESSION['Title'] = $title;
        $_REQUEST['Title'] = $title;
    }


    header("Location: createSet.php");
}
}

?>

