<?php
include('db_connect.php');
if(isset($_POST['add'])){
	$supervisor=$_POST['supervisor'];
	$password = "password";
	mysqli_query($con,"insert into team_supervisor(TeamSupervisor) values('$supervisor')");
	$result = mysqli_query($con,"SELECT * from team_supervisor WHERE TeamSupervisor = '".$supervisor."' ");
	$row = mysqli_fetch_array($result);
	mysqli_query($con,"insert into userlogin(Username, Password, Level, Name, employeeid) values('".$_POST['username']."', '".$password."','".$_POST['support']."','".$supervisor."','".$row['id']."')");
	mysqli_query($con,"UPDATE team_supervisor set employeeid = '".$row['id']."' WHERE id = '".$row['id']."'");

 	 $sqllog="INSERT INTO prlemplog (Username, ipaddress, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."', 'Added new supervisor ".$_POST['username']."')";	
	 mysqli_query($con,$sqllog);
	
	}
if(isset($_GET['task']) && $_GET['task'] =='delete'){
	mysqli_query($con,"delete from team_supervisor where id='".$_GET['id']."'");
	mysqli_query($con,"delete from userlogin where employeeid='".$_GET['id']."'");
	
 	 $sqllog="INSERT INTO prlemplog (Username, ipaddress, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."', 'Deleted supervisor ".$_GET['id']."')";	
	 mysqli_query($con,$sqllog);	
	}
if(isset($_GET['task']) && $_GET['task'] =='change'){
	
	if($_GET['level']=="N")
	{
		$level = '4';
	}
	else
	{
		$level = '2';
	}	
	mysqli_query($con,"UPDATE userlogin SET Level = '".$level."' where employeeid='".$_GET['id']."'");
	
 	 $sqllog="INSERT INTO prlemplog (Username, ipaddress, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."', 'Change To Support Group ".$_GET['id']."')";	
	 mysqli_query($con,$sqllog);	
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
-->
</style></head>

<body>
<p style="background-color:#CCC; font-size:14px"><strong>&nbsp;Add Supervisor</strong></p>

<form method="post">
  <p>Name of supervisor:
  <input name="supervisor" />
  </p>
  <p>Supervisor Log In Username:
    <input name="username" />
  (password will default to password)</p>
  <p>Support Group(Y/N): 
  <select name="support">
  <option value="2">No</option>
  <option value="4">Yes</option>
  </select></p>
  <p>
    <input type="submit" name="add" value="Add" />
  </p>
</form>
<br />

<table border="1" cellpadding="5">
<tr>
<td><strong> ID</strong></td>
<td><strong>Supervisor Name</strong></td>
<td align = "center"><strong>Support Group(Y/N)</strong></td>
<td><strong>Delete</strong></td>
</tr>
<?php
$getlist=mysqli_query($con,"select * from team_supervisor");
while($rowlist=mysqli_fetch_array($getlist))
{
	$getlevel=mysqli_query($con,"select * from userlogin WHERE employeeid = '".$rowlist['id']."'");
	$rowlevel=mysqli_fetch_array($getlevel);
	if($rowlevel['Level']=='2')
	{
		$level = "N";
	}
	else if($rowlevel['Level']=='4')
	{
		$level = "Y";
	}
?>
  <tr>
    <td><?php echo $rowlist['id']?></td>
    <td><?php echo $rowlist['TeamSupervisor']?></td>
    <td align="center">(<?php echo $level?>) <a href="addSupervisor.php?task=change&id=<?php echo $rowlist['id']?>&level=<?php echo $level?>">click to change</a></td>
    <td align="center"><a href="addSupervisor.php?task=delete&id=<?php echo $rowlist['id']?>"><img src="images/close.png" width="18" border="0" /></a></td>
  </tr>
<?php
}
?>
</table>

</body>
</html>