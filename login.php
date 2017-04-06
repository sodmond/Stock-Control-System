<?php
require_once('connection.php');
session_start();
if(!(isset($_POST['uname'], $_POST['pwd'])))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login :: CYBERNAULT STOCK CONTROL</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<style type="text/css">
#bg{background:#F6F6F6;}
#content{
	position:absolute; background:#EAEAEA;
	width:350px; height:300px;
	margin-left:175px; margin-top:150px;
	text-align:center;
	border:1px #0C6 dashed;
}
#content_header{font:24px "Trebuchet MS", Arial, Helvetica, sans-serif; color:#090;}
form p{font:18px Calibri;}
</style>
</head>

<body>
<div id="bg"></div>
<div id="header">

</div>

<div id="content">
<p id="content_header">ADMIN LOGIN</p>
<hr />
<div style="background:#FF6C70; color:#A40004;">
<?php if(isset($_SESSION['error'])){ echo $_SESSION['error']; unset($_SESSION['error']);} ?>
</div>
<div style="background:#6FF779; color:#0D870A;">
<?php if(isset($_SESSION['logout'])){ echo $_SESSION['logout']; unset($_SESSION['logout']);} ?>
</div>
<form method="post" name="logForm" action="<?php $_SERVER['PHP_SELF']; ?>">
<p>Username: <input type="text" name="uname" maxlength="10" size="30" /></p>
<p>Password: <input type="password" name="pwd" maxlength="15" size="30" /></p>
<p><input type="submit" value="Login" style="width:100px; height:40px;" /></p>
</form>
</div>

<div id="footer">
Cybernault(Nig) Ltd &copy; 2015
</div>
</body>
</html>
<?php
}
else{
	$uname = $_POST['uname'];
	$pwd = $_POST['pwd'];
	$query = mysqli_query($conn, 'SELECT COUNT(*) FROM admin WHERE (Username="'.$uname.'" AND Password="'.$pwd.'")');
	$result = mysqli_fetch_array($query);
	if($result[0] > 0){
		$_SESSION['user'] = $uname;
		header('Location: index.php');
	}
	else{
		$_SESSION['error'] = 'Invalid Username/Password';
		header('Location: login.php');
	}
}
?>