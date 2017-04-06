<?php
require_once("connection.php");
session_start();
if(isset($_SESSION['user']))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>More Options</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script src="js/script.js"></script>
</head>

<body>

<div id="bg"></div>
<div id="header"></div>

<div id="content">
<fieldset style="max-height:70px;">
<legend>Add Item(s)</legend>
<form method="post" action="add_itm.php">
<label for="itm">Enter Item Name:</label>
<input type="text" name="itm" class="inputTxt" style="width:190px; border-radius:5px;" required="required" />
<input type="submit" value=" Save " />
</form>
<div style="background:#6FF779; color:#0D870A; margin-top:10px;">
<?php if(isset($_SESSION['added'])){ echo $_SESSION['added']; unset($_SESSION['added']);} ?>
</div>
</fieldset>
<br />
<fieldset>
<legend>Change Password</legend>
<?php
$query = mysqli_fetch_array(mysqli_query($conn, 'SELECT S_Question, Answer FROM admin WHERE Username="'.$_SESSION['user'].'"'));
?>
<form method="post" name="secquestn" action="<?php $_SERVER['PHP_SELF']; ?>">
<div><b>Security Question :</b> <?php echo $query['S_Question']; ?></div>
<div><b>Answer :</b> <input type="password" name="ans" class="inputTxt" style="width:190px; border-radius:5px;" required="required" />
<input type="submit" value="Proceed" /></div>
</form>
<div style="background:#6FF779; color:#0D870A; margin-top:10px;">
<?php if(isset($_SESSION['pwd_chng'])){ echo $_SESSION['pwd_chng']; unset($_SESSION['pwd_chng']);} ?>
</div>
<?php
if(isset($_POST['ans'])){
	$ans = $_POST['ans'];
	if($ans == $query['Answer']){
?>
<form method="post" name="pwd" action="chng_pwd.php" style="border:1px #000 solid; margin-top:10px;" onsubmit="return pwdMatch();"><p>
<span>
<input type="password" name="N_pwd0" class="inputTxt" style="width:190px; border-radius:5px;" placeholder="New Password" required="required" />
</span>&nbsp;&nbsp;&nbsp;
<span>
<input type="password" name="N_pwd1" class="inputTxt" style="width:190px; border-radius:5px;" placeholder="Retype Password" required="required" />
</span>&nbsp;&nbsp;&nbsp;
<span><input type="submit" value="Save Changes" class="btn" style="height:25px;" /></span>
</p></form>
<?php
	}
	else{
		echo '<font color="#F00"><em>Answer is not correct!</em></font>';
	}
}
?>
</fieldset>

<div align="right" style="font:15px Calibri; margin-top:20px;">
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
}
else{
	header('Location: login.php');
}
?>