<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if(isset($_POST['itm'])){
		$itm = $_POST['itm'];
		$sql = mysqli_query($conn, "INSERT INTO products(ProductName) VALUES('".$itm."')");
		$_SESSION['added'] = 'Item added to Product list';
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