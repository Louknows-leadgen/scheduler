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
if($_GET['todo']== '10'){
?>
  <table width="589" border="1">
  <tr align="center">
  	<td width="35"><div align="center"><strong>Overtime ID</strong></div></td>
      <td width="209"><div align="center"><strong>Overtime Description</strong></div></td>
      <td width="106"><div align="center"><strong>Overtime Rate</strong></div></td>
      <td width="117"><div align="center"><strong>Edit</strong></div></td>
      <td width="156"><div align="center"><strong>Delete</strong></div></td>
  </tr>
<?php 	
  $result = mysqli_query($con,"SELECT * from prlovertimetable");
  while($row = mysqli_fetch_array($result)){
?>

    <tr>
    <td><div align="center">
      <?=$row['overtimeid']?>
    </div></td>
    <td><div align="center">
      <?=$row['overtimedescription']?>
    </div></td>
    <td><div align="center">
      <?=$row['overtimerate']?>
    </div></td>
        <td align="center"><a href="?todo=3&&overtimeid=<?=$row['overtimeid']?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
        <td align="center"><a href="?todo=4&&overtimeid=<?=$row['overtimeid']?>" alt="Delete" name="Delete" onClick="return confirm('Confirm Delete?')" ><img src="images/close.png" width="20"  /></a></td>    
    </tr>

<?php
  }
?>

</table>
<form method = "get" action = "" name = "tax">
  <p>
    <input type = "submit" name = "add" value = "Add Overtime Status" />
    <input type = "hidden" name = "todo" value = "1">
  </p>
</form>
<?php

}
else if($_GET['todo'] == '1'){
  echo "<table width='450' border='1'>";
  echo "<form method = 'get' action = '' name = 'addnewovertime'>";
  echo "<td width = '150'>Overtime ID: </td>";
  echo "<td><input type = 'text' name = 'overtimeid' size = '10'></td> </tr>";
  echo "<td>Overtime Description: </td>";
  echo "<td><input type = 'text' name = 'overtimedescription' size = '43'></td></tr>";
  echo "<td>Overtime Rate: </td>";
  echo "<td><input type = 'text' name = 'overtimerate' size = '10'></td></tr>";
  echo "<input type = 'hidden' name = 'todo' value = '2'>";   
  echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Add New Overtime Status'></td>";
  echo "</table>";
}

else if($_GET['todo'] == '2'){ 
  $sql = "INSERT INTO prlovertimetable (overtimeid, overtimedescription, overtimerate) VALUES ('$_GET[overtimeid]','$_GET[overtimedescription]','$_GET[overtimerate]')";

  if (!mysqli_query($con,$sql)){
    die('Error: ' . mysqli_connect_error());
  }

  echo "New Over Time Status Added!";								   
}   
   
else if($_GET['todo'] == '3'){
  $result = mysqli_query($con,"SELECT * from prlovertimetable WHERE overtimeid = '$_GET[overtimeid]'");
  $row = mysqli_fetch_array($result);  
  echo "<table width='450' border='1'>";
  echo "<form method = 'get' action = '' name = 'addnewstatus'>";
  echo "<td width = '150'>Over time ID: </td>";
  echo "<td>$row[overtimeid]</td> </tr>";
  echo "<td>OverTime Description: </td>";
  echo "<td><input type = 'text' name = 'overtimedescription' value = '$row[overtimedescription]' size = '43'></td></tr>";
  echo "<td>Overtime Rate: </td>";
  echo "<td><input type = 'text' name = 'overtimerate' value = '$row[overtimerate]' size = '43'></td></tr>";
  echo "<input type = 'hidden' name = 'todo' value = '35'>";
  echo "<input type = 'hidden' name = 'overtimeid' value = '$row[overtimeid]'>";   
  echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update'></td>";
  echo "</table>";
}

else if($_GET['todo'] == '35'){
  mysqli_query($con,"UPDATE prlovertimetable SET overtimedescription = '$_GET[overtimedescription]', overtimerate = '$_GET[overtimerate]' WHERE overtimeid = '$_GET[overtimeid]'");
    
  echo "data updated";												 
}   
      
else if($_GET['todo'] == '4'){
  mysqli_query($con,"DELETE FROM prlovertimetable WHERE overtimeid = '$_GET[overtimeid]'");
  
  echo " Deleted!!!";									 
}   
      
?>

