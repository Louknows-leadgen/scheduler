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
if(isset($_GET['todo']) && $_GET['todo']== '10')
{
?>
  <table width="589" border="1">
    <tr align="center">
    	<td width="35"><div align="center"><strong>Tax Status ID</strong></div></td>
        <td width="209"><div align="center"><strong>Tax Status</strong></div></td>
        <td width="117"><div align="center"><strong>Edit</strong></div></td>
        <td width="156"><div align="center"><strong>Delete</strong></div></td>
    </tr>
<?php 	
  $result = mysqli_query($con,"SELECT * from prltaxstatus");
  while($row = mysqli_fetch_array($result)){
?>

    <tr>
    <td><div align="center">
      <?=$row['taxstatusid']?>
    </div></td>
    <td><div align="center">
      <?=$row['taxstatusdescription']?>
    </div></td>
        <td align="center"><a href="?todo=3&&taxstatusid=<?=$row['taxstatusid']?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
        <td align="center"><a href="?todo=4&&taxstatusid=<?=$row['taxstatusid']?>" alt="Delete" name="Delete" onClick="return confirm('Confirm Delete?')" ><img src="images/close.png" width="20"  /></a></td>    
    </tr>

<?php
  }
?>

  </table>
  <form method = "get" action = "" name = "tax">

    <p>
      <input type = "submit" name = "add" value = "Add Tax Status" />
      <input type = "hidden" name = "todo" value = "1">
      
          </p>
  </form>
<?php

}

else if(isset($_GET['todo']) && $_GET['todo'] == '1'){
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addnewstatus'>";
   echo "<td width = '150'>Tax Status ID: </td>";
   echo "<td><input type = 'text' name = 'taxstatusid' size = '43'></td> </tr>";
   echo "<td>Tax Status Description: </td>";
   echo "<td><input type = 'text' name = 'taxstatus' size = '43'></td></tr>";
   echo "<input type = 'hidden' name = 'todo' value = '2'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Add New Tax Status'></td>";
   echo "</table>";
}
else if(isset($_GET['todo']) && $_GET['todo'] == '2'){ 
  $totalexemption = $_GET['personalexemption'] + $_GET['additionalexemption'];
  $sql="INSERT INTO prltaxstatus (taxstatusid, taxstatusdescription) VALUES ('$_GET[taxstatusid]','$_GET[taxstatus]')";
  if (!mysqli_query($con,$sql)){
    die('Error: ' . mysqli_connect_error());
  }	
	
  echo "New Tax Status Added!";								   
}   
   
else if(isset($_GET['todo']) && $_GET['todo'] == '3'){
	$result = mysqli_query($con,"SELECT * from prltaxstatus WHERE taxstatusid = '$_GET[taxstatusid]'");
	$row = mysqli_fetch_array($result);  
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addnewstatus'>";
   echo "<td width = '150'>Tax Status ID: </td>";
   echo "<td><input type = 'text' name = 'newtaxstatusid' value = '$row[taxstatusid]' size = '43'></td> </tr>";
   echo "<td>Tax Status Description: </td>";
   echo "<td><input type = 'text' name = 'taxstatus' value = '$row[taxstatusdescription]' size = '43'></td></tr>";
   echo "<input type = 'hidden' name = 'todo' value = '35'>";
   echo "<input type = 'hidden' name = 'taxstatusid' value = '$row[taxstatusid]'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update Status'></td>";
   echo "</table>";
}

else if(isset($_GET['todo']) && $_GET['todo'] == '35'){
  $totalexemption = $_GET['personalexemption'] + $_GET['additionalexemption'];
  mysqli_query($con,"UPDATE prltaxstatus SET taxstatusid = '$_GET[newtaxstatusid]', taxstatusdescription = '$_GET[taxstatus]' WHERE taxstatusid = '$_GET[taxstatusid]'");
  
  echo "data updated";												 
}   
      
else if(isset($_GET['todo']) && $_GET['todo'] == '4'){
  mysqli_query($con,"DELETE FROM prltaxstatus WHERE taxstatusid = '$_GET[taxstatusid]'");
  
  echo " Deleted!!!";									 
}   
      
?>

