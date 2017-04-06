<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if(isset($_POST['pdt'], $_POST['tPur'], $_POST['tSol'], $_POST['pBal'], $_POST['cBal'], $_POST['mnth'])){
		$pdt	=	$_POST['pdt'];
		$tPur 	= 	$_POST['tPur'];
		$tSol	=	$_POST['tSol'];
		$pBal	=	$_POST['pBal'];
		$cBal	=	$_POST['cBal'];
		$mnth	=	$_POST['mnth'];
		$query = mysqli_query($conn, 'INSERT INTO monthly_stock(ProductName, PreviousBalance, TotalPurchased, TotalSold, CurrentBalance, Month)
			VALUES("'.$pdt.'", "'.$pBal.'", "'.$tPur.'", "'.$tSol.'", "'.$cBal.'", "'.$mnth.'")');
		$_SESSION['suces'] = 'Record saved Successfully';
		header('Location: monthly_stock_bal.php');
	}
	else{
		header('Location: monthly_stock_bal.php');
	}
}
else{
	header('Location: login.php');
}
?>