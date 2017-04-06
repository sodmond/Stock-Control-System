<?php
require_once('connection.php');
session_start();
if(isset($_SESSION['user']))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monthly Stock Balance</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/script.js"></script>
</head>

<body>

<div id="bg"></div>
<div id="header"></div>
<div id="content" style="height:480px; overflow:auto;">
<?php
if($_SESSION['user']=='Admin'){
?>
<fieldset>
<legend>Stock Input Section</legend>
<form method="post" action="">
<label for="pdt">Select Product Name:</label>
<select name="pdt"><option value="0">- - - - - - - - - - - - - - - - - -</option>
<?php 
$query = mysqli_query($conn, ' SELECT * FROM `products` ORDER BY `ProductName` ');
while($product = mysqli_fetch_array($query)){ 
	echo '<option value="'.$product['ProductName'].'">'.$product['ProductName'].'</option>'; 
}
?>
</select>&nbsp;&nbsp;&nbsp;
<label for="mnth">Select Month:</label>
<select name="mnth">
<option value="00">- - - - - - - - - - -</option>
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
<input type="submit" value="Check" />
</form>

<?php
if(isset($_POST['pdt'], $_POST['mnth'])){
	$pdt 	= $_POST['pdt'];
	$mnth 	= $_POST['mnth'];
	$year 	= date('Y');
	$pmth 	= $year.'-0'.($mnth-1);
	$mnth	= $year.'-'.$mnth;
	$pur = mysqli_fetch_array(mysqli_query($conn, 
		'SELECT SUM(Quantity) FROM daily_stock WHERE (ProductName="'.$pdt.'" AND Date LIKE "%'.$mnth.'%" AND TransType="Purchased") '));
	$sol = mysqli_fetch_array(mysqli_query($conn, 
		'SELECT SUM(Quantity) FROM daily_stock WHERE (ProductName="'.$pdt.'" AND Date LIKE "%'.$mnth.'%" AND TransType="Sold") '));
	$pBal = mysqli_fetch_array(mysqli_query($conn, 
		'SELECT CurrentBalance FROM monthly_stock WHERE (ProductName="'.$pdt.'" AND Month="'.$pmth.'") '));
	$cBal = ($pBal['CurrentBalance']+$pur['SUM(Quantity)'])-$sol['SUM(Quantity)'];
	echo '<br><form method="post" action="mnth_stk_script.php">';
	echo '<table width="600" border="0" align="center" bgcolor="#00CC99" style="border:1px solid #000; font:0.8em Arial">';
	echo '<tr>';
	echo '<td>Product Name</td>';
	echo '<td>Previous Balance</td>';
	echo '<td>Total Purchased</td>';
	echo '<td>Total Sold</td>';
	echo '<td>Current Balance</td>';
	echo '<td>Month</td>';
	echo '<td>&nbsp;</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="pdt" size="10" value="'.$pdt.'" readonly="readonly" readonly="readonly" /></td>';
	echo '<td><input type="text" name="pBal" size="8" value="'.$pBal['CurrentBalance'].'" required="required" /></td>';
	echo '<td><input type="text" name="tPur" size="8" value="'.$pur['SUM(Quantity)'].'" required="required" /></td>';
	echo '<td><input type="text" name="tSol" size="5" value="'.$sol['SUM(Quantity)'].'" required="required" /></td>';
	echo '<td><input type="text" name="cBal" size="8" value="'.$cBal.'" required="required" /></td>';
	echo '<td><input type="text" name="mnth" size="6" value="'.$mnth.'" readonly="readonly" /></td>';
	echo '<td><input type="submit" value="Save" /></td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';
}
?>
<p style="color:#0F3; font:16px Arial; font-style:italic;">
<?php if(isset($_SESSION['suces'])){ echo $_SESSION['suces']; unset($_SESSION['suces']); } ?>
</p>
</fieldset>
<br />
<?php
}
?>

<fieldset>
<legend align="center">Monthly Stock</legend>
<div align="justify">
<form method="post" action="">
<label for="mnth">Month:</label>
<select name="mnth">
<option value="00">- - - - - - - - - - -</option>
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
&nbsp;&nbsp;&nbsp;
<label for="year">Year: </label>
<select name="year">
<option value="00">----------</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2018">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
</select>
<input type="submit" value="Check" />
</form>
</div>
</fieldset>

<fieldset style="height:350px;">
<div id="curStk">
<table width="97%" border="1" bordercolor="#CCC" bgcolor="#FFF" cellpadding="0" cellspacing="0" align="center">
<tr height="20" bgcolor="#000" style="color:#DDD; font:1.1em Cambria, 'Cambria Math'">
<td>ID</td>
<td>Product Name</td>
<td>Previous Balance</td>
<td>Total Purchased</td>
<td>Total Sold</td>
<td>Current Balance</td>
<td>Month</td>
</tr>
<?php
if(isset($_POST['mnth'], $_POST['year'])){
	$mnth	=	$_POST['mnth'];
	$year	=	$_POST['year'];
	$date	=	$year.'-'.$mnth;
	$sql = mysqli_query($conn, 'SELECT * FROM monthly_stock WHERE (Month="'.$date.'")');
	while($row = mysqli_fetch_array($sql)){
		echo '<tr style="color:#000; font:0.9em Calibri">';
		echo '<td>'.$row['ID'].'</td>';
		echo '<td>'.$row['ProductName'].'</td>';
		echo '<td>'.$row['PreviousBalance'].'</td>';
		echo '<td>'.$row['TotalPurchased'].'</td>';
		echo '<td>'.$row['TotalSold'].'</td>';
		echo '<td>'.$row['CurrentBalance'].'</td>';
		echo '<td>'.$row['Month'].'</td>';
		echo '</tr>';
	}
}
else{
	$now = date("Y-m");
	$sql = mysqli_query($conn, 'SELECT * FROM monthly_stock WHERE (Month="'.$now.'")');
	while($row = mysqli_fetch_array($sql)){
		echo '<tr style="color:#000; font:0.9em Calibri">';
		echo '<td>'.$row['ID'].'</td>';
		echo '<td>'.$row['ProductName'].'</td>';
		echo '<td>'.$row['PreviousBalance'].'</td>';
		echo '<td>'.$row['TotalPurchased'].'</td>';
		echo '<td>'.$row['TotalSold'].'</td>';
		echo '<td>'.$row['CurrentBalance'].'</td>';
		echo '<td>'.$row['Month'].'</td>';
		echo '</tr>';
	}
}
?>
</table>
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

</div>

<div id="footer">
Cybernault(Nig) Ltd &copy; 2015
</div>

</body>
</html>
<?php
}
else{
	header('Location: login.php');
}
?>