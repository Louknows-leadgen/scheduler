<?php
session_start();
include('db_connect.php');
if($_POST['task']=='changepass')
{
	$myusername=$_SESSION['Username'];
	$mypassword=$_POST['oldpassword'];
	$newpassword=$_POST['newpassword'];
	$confirmpassword=$_POST['confirmpassword'];
	if($mypassword=='')
	{
		$mess4="Old password is required";
		}
	else{	
	if($newpassword=='')
	{
		$mess2="Please input new password";
		}
	else{	
		if($confirmpassword!=$newpassword)
		{
			$mess3="New Password does not match!";
		}
		else{
			$result = mysqli_query($con,"SELECT * FROM userlogin WHERE Username='".$myusername."' and Password='".$mypassword."'");
			$row=mysqli_fetch_array($result);
			$numres=mysqli_num_rows($result);
			if($numres<=0){
				$mess1="Incorrect password";
			}
			else
			{  
			    echo "Password Changed";
				mysqli_query($con,"UPDATE userlogin SET Password = '".$newpassword."' WHERE ctr = '".$row['ctr']."'");
			}
		}
	}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
.errormess{
	
	color:#F00}
-->
</style></head>

<body>

<form method="post">
<table>
<tr>
	<td>Old Password:</td>
    <td><input type="text" name="oldpassword" /></td>
    <td class="errormess"><?php echo $mess4?> <?php echo $mess1?></td>
</tr>
<tr>
	<td>New Password:</td>
    <td><input type="text" name="newpassword" /></td>
    <td class="errormess"><?php echo $mess2?></td>
</tr>
<tr>
	<td>Confirm Password:</td>
    <td><input type="text" name="confirmpassword" /></td>
    <td class="errormess"><?php echo $mess3?></td>
</tr>
<tr>
	<td></td>
    <td><input type="submit" name="changepassword" value="Change Password" /></td>
</tr>
</table>
<input type="hidden" name="task" value="changepass" />
</form>
</body>
</html>