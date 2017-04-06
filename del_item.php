<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user'])){
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$itm = mysqli_fetch_array(mysqli_query($conn, 'SELECT ProductName FROM daily_stock WHERE ID="'.$id.'"'));
		$pdt = mysqli_fetch_array(mysqli_query($conn, 'SELECT ID FROM daily_stock WHERE ProductName="'.$itm['ProductName'].'" 
				ORDER BY ID DESC LIMIT 0,1'));
		if($id == $pdt['ID']){
			$sql = mysqli_query($conn, 'DELETE FROM daily_stock WHERE ID="'.$id.'"');
			$_SESSION['del_suc'] = 'Record Successfully deleted';
			header('Location: index.php');
		}
		else{
			$_SESSION['del_err'] = 'Record cannot be deleted';
			header('location: index.php');
		}
	}
}
else{
	header('Location: login.php');
}
?>