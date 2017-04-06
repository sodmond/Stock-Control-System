<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if($_POST['pdt'] != 0){
		$product = $_POST['pdt'];
		$_SESSION['col'] = 'ProductName';
		$_SESSION['val'] = $product;
		header('Location: stock_bal.php');
	}
	else{
		$_SESSION['empty'] = '<script>alert("Product cannot be empty!")</script>';
		header('Location: stock_bal.php');
	}
}
else{
	header('Location: login.php');
}
mysqli_close($conn);
?>