<?php

$connection= mysqli_connect('127.0.0.1', 'root', '', 'osbb');

if( $connection==false ){
	echo 'Failed to connect to database<br>';
	echo mysqli_connect_error();
	exit();
}
  ?>
