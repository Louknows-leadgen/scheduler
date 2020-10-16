<?php
session_start();
include('db_connect.php');
if(!isset($_SESSION['Username'])){
header("location:index.php");
}
?><table width="322" height="107" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	  <tr>
	    <form action="" method="post" name="form" id="form">
	      <td width="283"><table width="314" border="1" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
	        <tr>
	          <td colspan="3"><div align="center"><strong id="login2">Add User</strong></div></td>
	          </tr>
	        <tr>
	          <td width="87" id = "login2">Employee ID</td>
	          <td width="12" id = "login2">:</td>
	          <td width="184"><input name="myusername" type="text" width = "120" id="myusername" /></td>
	          </tr>
	        <tr>
	          <td width="87" id = "login2">Name</td>
	          <td width="12" id = "login2">:</td>
	          <td width="184"><input name="name" type="text" width = "180" id="name" /></td>
	          </tr>                         
	        <tr>
	          <td height="39">&nbsp;</td>
	          <td>&nbsp;</td>
              <input type="hidden" name="task" value="15" />
	          <td><input type="submit" name="Submit" value="Add User" /></td>
	          </tr>
          </table></td>
        </form>
      </tr>
    </table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php

if($_POST['task'] == '15')
{
$myusername=$_POST['myusername'];



$myusername = stripslashes($myusername);

$myusername = mysqli_real_escape_string($con,$myusername);


$result = mysqli_query($con,"SELECT * FROM paylogin WHERE Username='$myusername'");

$row = mysqli_num_rows($result);
$rowdata = mysqli_fetch_array($result);
if( $row == '1' ){

echo "Username Exists";

}

else if ($_SESSION['Level'] == '5')
{

	echo "New User Added!";
    mysqli_query($con,"INSERT INTO paylogin (Username,Level, Name)
	VALUES ('".$myusername."','1','".$_POST['name']."')");
	
	 	 $sqllog="INSERT INTO payloginlog (ip, description)
     VALUES
     ('".$_SERVER['REMOTE_ADDR']."','New User Added ".$myusername." by ".$_SESSION['Username']." ')";	
	 mysqli_query($con,$sqllog);

  
}

else
{echo "Insufficient Level To Create New Users";}

}

?>