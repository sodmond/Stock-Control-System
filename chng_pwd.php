<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if(isset($_POST['N_pwd0'], $_POST['N_pwd1'])){
		$nPwd = $_POST['N_pwd0'];
		$sql = mysqli_query($conn, "UPDATE admin SET Password='".$nPwd."' WHERE Username='".$_SESSION['user']."' ");
		$_SESSION['pwd_chng'] = 'Password Successfully Changed';
		header('Location: more.php');
	}
	else{
		header('Location: more.php');
	}
}
else{
	header('Location: login.php');
}
?>