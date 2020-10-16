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
</style><?php 
if($_GET['todo']== '10'){
?>
  <table width="589" border="1">
  <tr align="center">
  	<td width="51"><div align="center"><strong>Bracket</strong></div></td>
      <td width="89"><div align="center"><strong>Range From</strong></div></td>
      <td width="61"><div align="center"><strong>Range To</strong></div></td>
  	<td width="53"><div align="center"><strong>Salary Base</strong></div></td>
      <td width="98"><div align="center"><strong>Employer Share</strong></div></td>
      <td width="78"><div align="center"><strong>Employee Share</strong></div></td>    
      <td width="55"><div align="center"><strong>Total</strong></div></td><br>
      <td width="52"><div align="center"><strong>Edit</strong></div></td>
  </tr>
<?php 	
  $result = mysqli_query($con,"SELECT * from prlphilhealth");
  while($row = mysqli_fetch_array($result)){
?>

    <tr>
    <td><div align="center">
      <?=$row['bracket']?>
    </div></td>
    <td><div align="center">
      <?=$row['rangefrom']?>
    </div></td>
    <td><div align="center">
      <?=$row['rangeto']?>
    </div></td>
    <td><div align="center">
      <?=$row['salarycredit']?>
    </div></td>
    <td><div align="center">
      <?=$row['employerph']?>
    </div></td>
    <td><div align="center">
      <?=$row['employeeph']?>
    </div></td>
    <td><div align="center">
      <?=$row['total']?>
    </div></td>
        <td align="center"><a href="?todo=3&&bracket=<?=$row['bracket']?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
    </tr>

<?php
  }
?>

</table>
<?php

}

else if($_GET['todo'] == '3'){
	$result = mysqli_query($con,"SELECT * from prlphilhealth WHERE bracket = '$_GET[bracket]'");
	$row = mysqli_fetch_array($result);  
  echo "<table width='450' border='1'>";
  echo "<form method = 'get' action = '' name = 'addnewstatus'>";
  echo "<td width = '150'>Bracket: </td>";
  echo "<td>$row[bracket]</td> </tr>";
  echo "<td>Range From: </td>";
  echo "<td><input type = 'text' name = 'rangefrom' value = '$row[rangefrom]' size = '43'></td></tr>";
  echo "<td>Range To: </td>";
  echo "<td><input type = 'text' name = 'rangeto' value = '$row[rangeto]' size = '43'></td></tr>";
  echo "<td>Salary Credit: </td>";
  echo "<td><input type = 'text' name = 'salarycredit' value = '$row[salarycredit]' size = '43'></td></tr>";   
  echo "<td>Employers Share: </td>";
  echo "<td><input type = 'text' name = 'employerph' value = '$row[employerph]' size = '43'></td></tr>"; 
  echo "<td>Employees Share: </td>";
  echo "<td><input type = 'text' name = 'employeeph' value = '$row[employeeph]' size = '43'></td></tr>";           
  echo "<input type = 'hidden' name = 'todo' value = '35'>";
  echo "<input type = 'hidden' name = 'bracket' value = '$row[bracket]'>";   
  echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update'></td>";
  echo "</table>";
}

else if($_GET['todo'] == '35'){
  $total = $_GET['employerph'] + $_GET['employeeph'];
  mysqli_query($con,"UPDATE prlphilhealth SET bracket = '$_GET[bracket]', rangefrom = '$_GET[rangefrom]', rangeto = '$_GET[rangeto]',
												 salarycredit = '$_GET[salarycredit]', employerph = '$_GET[employerph]', employeeph = '$_GET[employeeph]', total = '$total' WHERE bracket = '$_GET[bracket]'");
  echo "data updated";												 
}   
      
    
?>

