<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if( ($_POST['pdt']=="0") && ($_POST['qty']=="") && ($_POST['trans']=="0")){
		$_SESSION['empty'] = 'Product / Quantity / TransactionType cannot be empty';
		header('Location: index.php');
	}
	else{
		$pdt 	= $_POST['pdt'];
		$qty	= $_POST['qty'];
		$trans	= $_POST['trans'];
		$stmt = ' SELECT Balance FROM daily_stock WHERE ProductName="'.$pdt.'" ORDER BY ID DESC LIMIT 0,1 ';
		$sql = mysqli_fetch_array(mysqli_query($conn, $stmt));
		$balnc = $sql['Balance'];
		$bal = "";
		if($trans == 'Purchased'){ $bal = $balnc+$qty; }
		else if($trans == 'Sold'){ $bal = $balnc-$qty; } 
		else{
			$_SESSION['trans'] = 'Select a Transaction type';
			header('Location: index.php');
		}
		$stmt01 = 'INSERT INTO daily_stock(ProductName, TransType, Quantity, Balance) VALUES("'.$pdt.'", "'.$trans.'", "'.$qty.'", "'.$bal.'")';
		$query = mysqli_query($conn, $stmt01);
		$_SESSION['stock_s'] = "Record Stored Succesfully";
		header('Location: index.php');
	}
}
else{
	header('Location: login.php');
}
?>