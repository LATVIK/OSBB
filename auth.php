<?php
	include('connect.php');

if(isset($_POST)){
if(isset($_POST['email'], $_POST['password'])){
      $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
      $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
      $password = md5($password.'sol999');
      $user = mysqli_query($connection, "SELECT `id` as 'id' FROM `tenant` WHERE `email` ='$email' and `password` = '$password'");
      if(!$user){
      	echo "Request failed, contact administrator";
      	exit();
      }
     
      $user = $user->fetch_all(MYSQLI_ASSOC);
      if(count($user)==0){
      	
      	header('Location: ../OSMD/signin.php');
      	exit();
    	}else{
     
    	setcookie('userId', $user[0]['id'], time()+ 3600*24*32, "/OSBB/");
    	
		header('Location: ../OSBB/index.php');
		exit();
      }

    }
}


header('Location: ../OSBB/signin.php');
exit();

?>
