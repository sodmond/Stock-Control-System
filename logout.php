<?php
session_start();
if(isset($_SESSION['user'])){
	unset($_SESSION['user']);
	session_destroy();
	session_start();
	$_SESSION['logout'] = 'You have sucessfully logged out';
	header('Location: login.php');
}
else{
	header('Location: login.php');
}
?>