<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if(!(empty($_POST['sDate']))){
		$date = $_POST['sDate'];
		$_SESSION['col'] = 'Date';
		$_SESSION['val'] = $date;
		header('Location: stock_bal.php');
	}
	else{
		$_SESSION['emptyDate'] = '<script>alert("Date cannot be empty!")</script>';
		header('Location: stock_bal.php');
	}
}
else{
	header('Location: login.php');
}
mysqli_close($conn);
?>