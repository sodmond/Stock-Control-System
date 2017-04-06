<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user']))
{
	if(isset($_SESSION['empty'])){echo $_SESSION['emptyDate']; unset($_SESSION['emptyDate']); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stock Balance</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" media="all" href="calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="calendar/jquery.1.4.2.js"></script>
<script type="text/javascript" src="calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">
window.onload = function(){
	new JsDatePick({
		useMode:2,
		target:"sDate",
		dateFormat:"%Y-%m-%d",
		cellColorScheme:"armygreen"
	});
};
</script>
<style type="text/css">
#stkTable{
	border:1px #DDD ridge;
}
</style>
</head>

<body>
<div id="bg"></div>
<div id="header">
</div>

<div id="content">
<fieldset>
<legend align="center">Advance Stock</legend>
<table align="center" id="stkTable"><tr><td>
<form method="post" action="stock_bal-date.php" style="border:1px solid #FFF; padding:3px;">
<span>Select a date: <input type="text" name="sDate" id="sDate" size="10" readonly="readonly" /></span>
<span><input type="submit" value="Check" /></span> 
</form>
</td>
<td>&nbsp;&Omega;&nbsp;</td>
<td> 
<form action="stock_bal-pdt.php" method="post" style="border:1px solid #FFF; padding:3px;">
<span>Product: <select name="pdt"><option value="0">- - - - - - - - - - - - - - - - - -</option>
<?php 
$query = mysqli_query($conn, ' SELECT * FROM `products` ORDER BY `ProductName` ');
while($product = mysqli_fetch_array($query)){ 
	echo '<option value="'.$product['ProductName'].'">'.$product['ProductName'].'</option>'; 
}
?>
</select></span>
<span><input type="submit" value="Check" /></span>
</form>
</td>
</tr></table>
</fieldset>

<fieldset style="height:350px; overflow:auto;">
<div id="curStk">
<div id="pTxT" align="center" style="visibility:hidden;">
<em>Stock Balance for</em> <strong><?php echo $_SESSION['val']; ?></strong> 
</div>
<table width="97%" border="1" bordercolor="#CCC" bgcolor="#FFF" cellpadding="0" cellspacing="0" align="center">
<tr height="20" bgcolor="#000" style="color:#DDD; font:1.1em Cambria, 'Cambria Math'">
<td>ID</td>
<td>Product Name</td>
<td>Transaction Type</td>
<td>Quantity</td>
<td>Balance</td>
<td>Date</td>
</tr>
<?php
if(isset($_SESSION['col'], $_SESSION['val'])){
	$col = $_SESSION['col'];
	$val = $_SESSION['val'];
	$stmt = '';
	if($col == 'Date'){
		$stmt = 'SELECT * FROM daily_stock WHERE (Date LIKE "'.$val.'%") ORDER BY ID';
	}
	else{
		$stmt = 'SELECT * FROM daily_stock WHERE (ProductName="'.$val.'") ORDER BY ID';
	}
	$sql = mysqli_query($conn, $stmt);
	while($row = mysqli_fetch_array($sql)){	
		echo '<tr style="color:#000; font:0.9em Calibri; text-align:center;">';
		echo '<td>'.$row['ID'].'</td>';
		echo '<td>'.$row['ProductName'].'</td>';
		echo '<td>'.$row['TransType'].'</td>';
		echo '<td>'.$row['Quantity'].'</td>';
		echo '<td>'.$row['Balance'].'</td>';
		echo '<td>'.$row['Date'].'</td>';
		echo '</tr>';
	}
	unset($_SESSION['col'], $_SESSION['val']);
}
else{
	echo '<tbody><i>*** No result Found ***</i></tbody>';
}
?>
</table>
<p align="right" id="prt"><em>Date Printed:</em> <?php echo date("Y-m-d h:i:s") ?></p>
</div>
<p align="center"><button class="btn" onclick="printStk()">Print</button></p>
</fieldset>
<div align="right" style="font:15px Calibri;">
<a href="index.php" >Home</a> | 
<a href="stock_bal.php">Advance Stock</a> | 
<a href="monthly_stock_bal.php">Monthly Stock</a> | 
<a href="more.php">More</a> | 
<a href="logout.php">Logout (<?php echo $_SESSION['user']; ?>)</a></div>
</div>

<div id="footer">
Cybernault(Nig) Ltd &copy; 2015
</div>
</body>
</html>
<?php
mysqli_close($conn);
}
else{
	header('Location: login.php');
}
?>