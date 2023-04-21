<?php
include 'connect.php';


$title = $_POST['title'];
$text = $_POST['text'];
$author_id = $_POST['author_id'];
	
if($title != "" and $text!=""){
$result = mysqli_query($connection, "INSERT INTO `post` (`title`, `author_id`, `text`) VALUES ('$title', '$author_id', '$text')");
		
}
header('Location: /OSBB/index.php');



?>

