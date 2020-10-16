<?php
session_start();
if(!isset($_SESSION['Username'])){
header("location:index.php");
}
include("db_connect.php");

if($_POST['todo']==15)
{
	/*Updating status to ACtive or Inactive*/
	mysqli_query($con,"UPDATE prlemployeemaster SET active = '".$_POST['active']."' WHERE employeeid = '".$_POST['employeeid']."'");
	/*Removing from team assignment*/
	if($_POST['active'] == 1)
    mysqli_query($con,"DELETE from teamassignment WHERE employeeid = '".$_POST['employeeid']."'");
	
	echo "Status of Employee ".$_POST['employeeid']." changed!<br>";
 	 $sqllog="INSERT INTO prlemplog (Username, ipaddress, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."', 'UPDATE active status of employee ".$_POST['employeeid']."')";	
	 mysqli_query($con,$sqllog);
}



echo "<table border ='1'/>";
echo "<tr>";
echo "<td>"; echo " Employee ID "; echo "</td>";
echo "<td>"; echo " Last Name "; echo "</td>";
echo "<td>"; echo " First Name "; echo "</td>";
echo "<td>"; echo " Active "; echo "</td>";
echo "<td>"; echo " Change "; echo "</td>";
echo "</tr>";

$result = mysqli_query($con,"SELECT employeeid, firstname, lastname, active FROM prlemployeemaster ORDER by active, lastname asc");
while($row=mysqli_fetch_array($result))
{
?>	
  <tr>
  <td align="center"><?php echo $row['employeeid']?></td>	
  <td align="center"><?php echo $row['lastname']?></td>
  	<td align="center"><?php echo $row['firstname']?></td>
  <form method = "post" action="">
  <td align="center"><select name = "active">
  <option value="0" <?php if($row['active']=='0'){ echo 'selected="selected"';} ?>> Active </option>
  <option value="1" <?php if($row['active']=='1'){ echo 'selected="selected"';} ?>> In Active </option>
  </select>
  </td>
  <input type = "hidden" name = "todo" value ="15">
  <input type = "hidden" name = "employeeid" value ="<?php echo $row['employeeid']; ?>">
  <td align="center"><input type = "submit" name = "change" value = "Change"></td>
  </form>
  </tr>
<?php
}
echo "</table>";
?>