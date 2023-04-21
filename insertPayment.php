<?php
include 'connect.php';


$flat_id = $_POST['flat_id'];
$sum = $_POST['sum'];

$result = mysqli_query($connection, "INSERT INTO `payment` (`flat_id`, `sum`) VALUES ('$flat_id', '$sum')");
		

header('Location: /OSBB/personalArea.php');



?>

