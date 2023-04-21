<?php 
    	setcookie('userId', ' ', time() - 3600*24*32, "/OSBB/");
header('Location: ../OSBB/signin.php');
?>