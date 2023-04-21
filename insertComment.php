<?php
include 'connect.php';

header('Content-Type: text/html');

$userId = $_COOKIE['userId'];
$postId = $_POST['postId'];
$userComment = $_POST['userComment'];



$result = mysqli_query($connection, "INSERT INTO `comment` (`post_id`, `author_id`, `text`) VALUES ('$postId', '$userId', '$userComment')");
		


?>