<?php
	include('connect.php');

	$flat = filter_var(trim($_POST['flat']), FILTER_SANITIZE_STRING);
	$surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
	$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
	$middle_name = filter_var(trim($_POST['middle_name']), FILTER_SANITIZE_STRING);
	$phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
	$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
	$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);


	$password = md5($password.'sol999');
	if($flat<1 || mb_strlen($surname)<1 || mb_strlen($name)<1  ||mb_strlen($phone)<6  ||mb_strlen($email)<1  ||mb_strlen($password)<1  ){
		echo "registration";
		header('Location: /OS/registration.php');
		exit();
	}else{
		$user = mysqli_query($connection, "SELECT `id` FROM `tenant` WHERE `email` ='$email' ");
		$user = $user->fetch_all(MYSQLI_ASSOC);
		if(count($user)>0){
			echo $email.'<br>';
      		echo "User with this email already exists";
      		exit();
    	}

		$result = mysqli_query($connection, "INSERT INTO `tenant` (`flat_id`, `surname`, `name`, `middle_name`, `phone`, `email`, `password`) VALUES ('$flat', '$surname', '$name', '$middle_name', '$phone', '$email', '$password')");
		if(!$result){
			echo "The user is not added, please check the correctness of the entered data";
			}else {
			
			$user = mysqli_query($connection, "SELECT `id` as 'id' FROM `tenant` WHERE `email` ='$email' and `password` = '$password'");
      		if(!$user){
      		echo "User not added";
      		exit();
      		}
     
      $user = $user->fetch_all(MYSQLI_ASSOC);
      if(count($user)==0){
      	echo "signin";
      	//header('Location: ../OSBB/signin.php');
      	exit();
    	}else{
   
    	setcookie('user_id', $user[0]['id'], time()+ 3600*24*32, "/OSBB/");
    	echo "index in end";
		header('Location: ../OSBB/index.php');
		exit();
      	}

	}
}

?>


