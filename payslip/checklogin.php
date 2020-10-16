<?php
$con = mysqli_connect("localhost", "digicono_HRadmin", "DigiC0n0nlin3!","digicono_hris");
  if (!$con)
      {
       die('Could not connect: ' . mysqli_connect_error());
      }
// mysql_select_db("digicono_hris",$con);

$myusername=$_POST['agentid'];
$mypassword=$_POST['password'];


$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysqli_real_escape_string($con,$myusername);
$mypassword = mysqli_real_escape_string($con,$mypassword);

session_start();
$result = mysqli_query($con,"SELECT * FROM paylogin WHERE Username='$myusername' and Password='$mypassword'");

$row = mysqli_num_rows($result);
$rowdata = mysqli_fetch_array($result);
if( $row == '1' ){
$_SESSION['Username'] = $myusername;
$_SESSION['Password'] = $mypassword;
$_SESSION['Level'] = $rowdata['Level'];

 	 $sqllog="INSERT INTO payloginlog (ip, description)
     VALUES
     ('".$_SERVER['REMOTE_ADDR']."','LOGIN ".$myusername."')";	
	 mysqli_query($con,$sqllog);

header("location:digitalconnection.php");
}
else {
mysqli_close($con); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Digital Connection I.T. Services</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="stylelog.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
</head>
<body>
<div id="wrapper">
 <div id="dci_logo">
   <h1><a href="">Xactcall Corporation</a></h1>
 </div><!---dci_logo--->
 <div id="main_content">
   <p>Please log in to add or make changes!</p>
   <h4>LOG IN FAILED!</h4>
   <h3><a href="index.php">Go Back to Login</a></h3>
 </div><!---main_content--->
 <div id="footer">
  <h6>2015 Xactcall Corporation All rights reserved.</h6>
 </div>
</div><!---wrapper--->
</body>
</html>

<?php } ?>