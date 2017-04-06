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
<title>CYBERNAULT STOCK CONTROL</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/script.js"></script>
<style type="text/css">
#stkTable{
	border:1px #DDD ridge;
}
</style>
</head>

<body>

<div id="bg"></div>
<div id="header"></div>

<div id="content">
<fieldset style="height:90px;">
<legend>Stock Input Section</legend>
<div style="background:#FF6266; color:#A80004; font:15px Calibri; font-style:italic;">
<?php if(isset($_SESSION['empty'])){ echo $_SESSION['empty']; unset($_SESSION['empty']); } ?>
</div>
<div style="background:#93FF6F; color:#109D00; font:15px Calibri; font-style:italic;">
<?php if(isset($_SESSION['stock_s'])){ echo $_SESSION['stock_s']; unset($_SESSION['stock_s']); } ?>
</div>
<form action="stock-input-script.php" method="post">
<span>Item: <select name="pdt" class="inputTxt" style="background:#0C3;">
<option value="0">- - - - - - - - - - - - - - - - - -</option>
<?php 
$query = mysqli_query($conn, ' SELECT * FROM `products` ORDER BY `ProductName` ');
while($product = mysqli_fetch_array($query)){ 
	echo '<option value="'.$product['ProductName'].'">'.$product['ProductName'].'</option>'; 
}
?>
</select></span>&nbsp;&nbsp;
<span>Quantity: <input type="text" name="qty" class="inputTxt" size="4" required="required" /></span>&nbsp;&nbsp;
<span>Transaction Type: <select name="trans" class="inputTxt" style="background:#0C3;">
<option value="0">- - - - - - - - - -</option>
<option value="Purchased">Purchased</option>
<option value="Sold">Sold</option>
</select></span>
<div style="padding:10px;"><input type="submit" value="Store" class="btn" style="width:100px; height:30px;" /></div>
</form>
</fieldset>

<br />

<fieldset style="height:310px; overflow:auto;">
<legend>Stock Balance for Today</legend>
<div style="text-align:right; font:14px Georgia;">
<div id="curStk">
<div id="pTxT" style="visibility:hidden;"><em>Stock Balance for</em> <strong><?php echo date('Y-m-d'); ?></strong></div>
<table width="95%" border="1" bordercolor="#CCC" bgcolor="#FFF" cellpadding="0" cellspacing="0" align="center">
<tr height="20" bgcolor="#000" style="color:#DDD; font:1.2em Cambria; text-align:center;">
<td>ID</td>
<td>Product Name</td>
<td>Transaction Type</td>
<td>Quantity</td>
<td>Balance</td>
<td>Date</td>
</tr>
<?php
$date = date('Y-m-d').'%';
$sql = mysqli_query($conn, 'SELECT * FROM daily_stock WHERE Date LIKE "'.$date.'" ORDER BY ID');
while($result = mysqli_fetch_array($sql)){
	echo '<tr style="color:#000; font:1.0em Calibri; text-align:center;">';
	echo '<td>'.$result['ID'].'</td>';
	echo '<td>'.$result['ProductName'].'</td>';
	echo '<td>'.$result['TransType'].'</td>';
	echo '<td>'.$result['Quantity'].'</td>';
	echo '<td>'.$result['Balance'].'</td>';
	echo '<td>'.$result['Date'].'</td>';
	echo '</tr>';
}
?>
</table>
<p align="right" id="prt"><em>Date Printed:</em> <?php echo date("Y-m-d h:i:s") ?></p>
</div>
<p align="center"><button class="btn" onclick="printStk()">Print</button></p>
<div align="center" style="background:#DDD; border:1px #060 dashed;">
<form method="post" action="del_item.php">
<label for="id">Enter ID: </label>
<input type="text" name="id" size="5" required="required" />
<input type="submit" value="Delete" />
</form>
<div style="background:#93FF6F; color:#109D00; font:15px Calibri; font-style:italic;">
<?php if(isset($_SESSION['del_suc'])){ echo $_SESSION['del_suc']; unset($_SESSION['del_suc']); } ?>
</div>
<div style="background:#FF6266; color:#A80004; font:15px Calibri; font-style:italic;">
<?php if(isset($_SESSION['del_err'])){ echo $_SESSION['del_err']; unset($_SESSION['del_err']); } ?>
</div>

</div>
</fieldset>
<div align="right" style="font:15px Calibri;">
<a href="index.php" style="font:15px Calibri;">Home</a> | 
<a href="stock_bal.php">Advance Stock</a> | 
<a href="monthly_stock_bal.php">Monthly Stock</a> | 
<a href="more.php">More</a> | 
<a href="logout.php">Logout (<?php echo $_SESSION['user']; ?>)</a>
</div>

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