<?php
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
</style>
<?php 
if($_GET['todo']== '10')
{
?>
<table width="589" border="1">
<tr align="center">
	<td width="35"><div align="center"><strong>Leave ID</strong></div></td>
    <td width="209"><div align="center"><strong>Leave Description</strong></div></td>
    <td width="209"><div align="center"><strong>Paid / Unpaid</strong></div></td>    
    <td width="106"><div align="center"><strong>Gender Specific</strong></div></td>
    <td width="117"><div align="center"><strong>Edit</strong></div></td>
    <td width="156"><div align="center"><strong>Delete</strong></div></td>
</tr>
<?php 	$result = mysqli_query($con,"SELECT * from prlleavetable ORDER BY leavedescription asc");
        while($row = mysqli_fetch_array($result))
		{
?>

<tr>
<td><div align="center">
  <?php echo $row['leaveid']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['leavedescription']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['paid']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['gender']; ?>
</div></td>

    <td align="center"><a href="?todo=3&&leaveid=<?php echo $row['leaveid']; ?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
    <td align="center"><a href="?todo=4&&leaveid=<?php echo $row['leaveid']; ?>" alt="Delete" name="Delete" onClick="return confirm('Confirm Delete?')" ><img src="images/close.png" width="20"  /></a></td>    
</tr>

<?php
         }
?>

</table>
<form method = "get" action = "" name = "leave">

  <p>
    <input type = "submit" name = "add" value = "Add New Leave" />
    <input type = "hidden" name = "todo" value = "1">
    
        </p>
</form>
<?php

}

else if($_GET['todo'] == '1'){
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addleave'>";
   echo "<td>Leave Description: </td>";
   echo "<td><input type = 'text' name = 'leavedescription' size = '43'></td></tr>";
   echo "<td>Paid / Unpaid: </td>";   
   echo "<td><select name='paid'>
				      <option value='Paid'>Paid</option>
				      <option value='Non-Paid'>Non-Paid</option>
				      </select><td> </tr>";
   echo "<td>Gender Specific: </td>";   
   echo "<td><select name='gender'>
				      <option value='Male'>Male Only</option>
				      <option value='Female'>Female Only</option>
				      <option value='All'>All</option>
				      </select><td> </tr>";  
   echo "<input type = 'hidden' name = 'todo' value = '2'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newleave' value = 'Add New Leave'></td>";
   echo "</table>";
}

else if($_GET['todo'] == '2'){ 
	// mysql_select_db("VectorBPO", $con);   
  $sql = "INSERT INTO prlleavetable (leavedescription, paid, gender) VALUES ('$_GET[leavedescription]','$_GET[paid]','$_GET[gender]')";
	if (!mysqli_query($con,$sql)){
    die('Error: ' . mysqli_connect_error());
  }	
	 echo "New Leave Added!";								   
}   

else if($_GET['todo'] == '3'){
	$result = mysqli_query($con,"SELECT * from prlleavetable WHERE leaveid = '$_GET[leaveid]'");
	$row = mysqli_fetch_array($result);  
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addnewleave'>";
   echo "<td width = '150'>Leave ID: </td>";
   echo "<td>"; echo $row['leaveid']; echo "</td> </tr>";
   echo "<td>Leave Description: </td>";
   echo "<td><input type = 'text' name = 'leavedescription' value = '$row[leavedescription]' size = '43'></td></tr>";
   echo "<td>Paid / Non-Paid: </td>"; 
   echo "<td><select name='paid'>
                      <option value='$row[paid]'>$row[paid]</option>
				      <option value='Paid'>Paid</option>
				      <option value='Non-Paid'>Non-Paid</option>
				      </select><td> </tr>";        
   echo "<td>Gender Specific: </td>";   
   echo "<td><select name='gender'>
                      <option value='$row[gender]'>$row[gender]</option>
				      <option value='Male'>Male Only</option>
				      <option value='Female'>Female Only</option>
				      <option value='All'>All</option>
				      </select><td> </tr>"; 					  
   echo "<input type = 'hidden' name = 'todo' value = '35'>";
   echo "<input type = 'hidden' name = 'leaveid' value = '$row[leaveid]'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update Leave'></td>";
   echo "</table>";
}

else if($_GET['todo'] == '35'){ 
  mysqli_query($con,"UPDATE prlleavetable SET leavedescription = '$_GET[leavedescription]', paid = '$_GET[paid]', gender = '$_GET[gender]' WHERE leaveid = '$_GET[leaveid]'");

  echo "data updated";												 
}   
      
else if($_GET['todo'] == '4'){
  mysqli_query($con,"DELETE FROM prlleavetable WHERE leaveid = '$_GET[leaveid]'");

  echo " Deleted!!!";									 
}   
      
?>
