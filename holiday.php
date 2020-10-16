<?php
session_start();
if(!isset($_SESSION['Code'])){
header("location:index.php");}
include("db_connect.php");
?>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
img{
border:0;}
-->
</style><?php 
if($_GET['todo']== '10')
{
?>
<table width="750" border="1">
<tr align="center">
	<td width="54"><div align="center"><strong>Holiday ID</strong></div></td>
    <td width="195"><div align="center"><strong>Holiday Description</strong></div></td>
    <td width="96"><div align="center"><strong>Holiday Date</strong></div></td>
    <td width="135"><div align="center"><strong>Holiday Type</strong></div></td>   
    <td width="68"><div align="center"><strong>Edit</strong></div></td>
    <td width="76"><div align="center"><strong>Delete</strong></div></td>
</tr>
<?php 	$result = mysqli_query($con,"SELECT * from prlholidaytable ORDER BY holidaydate asc");
        while($row = mysqli_fetch_array($result))
		{
?>

<tr>
<td><div align="center">
  <?php echo $row['holidayid']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['holidaydescription']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['holidaydate']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['holidaytype']; ?>
</div></td>
    <td align="center"><a href="?todo=3&&holidayid=<?php echo $row['holidayid']; ?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
    <td align="center"><a href="?todo=4&&holidayid=<?php echo $row['holidayid']; ?>" alt="Delete" name="Delete" onClick="return confirm('Confirm Delete?')" ><img src="images/close.png" width="20"  /></a></td>    
</tr>

<?php
         }
?>

</table>
<form method = "get" action = "" name = "tax">

  <p>
    <input type = "submit" name = "add" value = "Add Holiday" />
    <input type = "hidden" name = "todo" value = "1">
    
        </p>
</form>
<?php

}
else if($_GET['todo'] == '1')
  {
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addnewholiday'>";
   echo "<td width = '150'>Holiday Description: </td>";
   echo "<td><input type = 'text' name = 'holidaydescription' size = '35'></td> </tr>";
   echo "<td>Holiday Date: </td>";
   echo "<td><input type = 'text' name = 'holidaydate' size = '8'>(yyyy-mm-dd)</td></tr>";
   echo "<td>Holiday Type: </td>";
   echo "<td><select name='holidaytype'>
				      <option value='Regular Holiday'>Regular Holiday</option>
				      <option value='Special Holiday'>Special Holiday</option>
					  <option value='No Work with Pay'>No Work With Pay</option>
					  <option value='No Work No Pay'>No Work No Pay</option>
					  <option value='Double Holiday'>Double Holiday</option>
				      </select><td> </tr>";  				   
   echo "<input type = 'hidden' name = 'todo' value = '2'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newholiday' value = 'Add New Holiday'></td>";
   echo "</table>";
   }
else if($_GET['todo'] == '2')
   { 
     $sql="INSERT INTO prlholidaytable (holidaydescription, holidaydate, holidaytype)
     VALUES
     ('$_GET[holidaydescription]','$_GET[holidaydate]','$_GET[holidaytype]')";
	                       if (!mysqli_query($con,$sql))
                         {
                          die('Error: ' . mysqli_connect_error());
                         }	
	 echo "New Holiday Date Added!";								   
   }   
   
else if($_GET['todo'] == '3')
  {
	$result = mysqli_query($con,"SELECT * from prlholidaytable WHERE holidayid = '$_GET[holidayid]'");
	$row = mysqli_fetch_array($result);  
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addnewholiday'>";
   echo "<td width = '150'>Holiday ID: </td>";
   echo "<td>$row[holidayid]</td> </tr>";
   echo "<td>Holiday Description: </td>";
   echo "<td><input type = 'text' name = 'holidaydescription' value = '$row[holidaydescription]' size = '43'></td></tr>";
   echo "<td>Holiday Date: </td>";
   echo "<td><input type = 'text' name = 'holidaydate' value = '$row[holidaydate]' size = '43'></td></tr>";   
   echo "<td>Holiday Type: </td>";
   echo "<td><select name='holidaytype'>
                      <option value='$row[holidaytype]'>$row[holidaytype]</option>
				      <option value='Regular Holiday'>Regular Holiday</option>
				      <option value='Special Holiday'>Special Holiday</option>
					  <option value='No Work No Pay'>No Work No Pay</option>
					  <option value='Double Holiday'>Double Holiday</option>
				      </select><td> </tr>";
   echo "<input type = 'hidden' name = 'todo' value = '35'>";
   echo "<input type = 'hidden' name = 'holidayid' value = '$row[holidayid]'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update'></td>";
   echo "</table>";
   }
else if($_GET['todo'] == '35')
  {
    mysqli_query($con,"UPDATE prlholidaytable SET holidaydescription = '$_GET[holidaydescription]',
	                                             holidaydate = '$_GET[holidaydate]',
												 holidaytype = '$_GET[holidaytype]'
												 WHERE holidayid = '$_GET[holidayid]'");
    echo "data updated";												 
   }   
      


else if($_GET['todo'] == '4')
  {
     mysqli_query($con,"DELETE FROM prlholidaytable WHERE holidayid = '$_GET[holidayid]'");
     echo " Deleted!!!";									 
   }   
      
?>
