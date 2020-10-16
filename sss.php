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
if(isset($_GET['todo']) && $_GET['todo']== '10')
{
$con = mysqli_connect("localhost","digicono_HRadmin","DigiC0n0nlin3!","internal");
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_connect_error());
	  }
	
	// mysql_select_db("internal", $con);
?>
<table width="691" border="1">
<tr align="center">
	<td width="51"><div align="center"><strong>Bracket</strong></div></td>
    <td width="79"><div align="center"><strong>Range From</strong></div></td>
    <td width="68"><div align="center"><strong>Range To</strong></div></td>
	<td width="69"><div align="center"><strong>Salary Credit</strong></div></td>
    <td width="135"><div align="center"><strong>Employer Share + EC</strong></div></td>
    <td width="99"><div align="center"><strong>Employee Share</strong></div></td>    
    <td width="71"><div align="center"><strong>Total Contribution</strong></div></td><br>
    <td width="67"><div align="center"><strong>Edit</strong></div></td>
</tr>
<?php 	$result = mysqli_query($con,"SELECT * from prlsstable");
        while($row = mysqli_fetch_array($result))
		{
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
  <?=$row['employerss']?> <strong> + </strong> <?=$row['employerec']?>
</div></td>
<td><div align="center">
  <?=$row['employeess']?>
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

else if(isset($_GET['todo']) && $_GET['todo'] == '3')
  {
   $con = mysqli_connect("localhost","digicono_HRadmin","DigiC0n0nlin3!","internal");
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_connect_error());
	  }
	
	// mysql_select_db("internal", $con);
	$result = mysqli_query($con,"SELECT * from prlsstable WHERE bracket = '$_GET[bracket]'");
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
   echo "<td><input type = 'text' name = 'employerss' value = '$row[employerss]' size = '43'></td></tr>"; 
   echo "<td>Employees Share: </td>";
   echo "<td><input type = 'text' name = 'employeess' value = '$row[employeess]' size = '43'></td></tr>";           
   echo "<input type = 'hidden' name = 'todo' value = '35'>";
   echo "<input type = 'hidden' name = 'bracket' value = '$row[bracket]'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update'></td>";
   echo "</table>";
   }
else if(isset($_GET['todo']) && $_GET['todo'] == '35')
  {
   $con = mysqli_connect("localhost","digicono_HRadmin","DigiC0n0nlin3!","internal");
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_connect_error());
	  }
	
	// mysql_select_db("internal", $con);
	$total = $_GET['employerss'] + $_GET['employeess'];
    mysqli_query($con,"UPDATE prlsstable SET bracket = '$_GET[bracket]',
	                                             rangefrom = '$_GET[rangefrom]',
												 rangeto = '$_GET[rangeto]',
												 salarycredit = '$_GET[salarycredit]',
												 employerss = '$_GET[employerss]',
												 employeess = '$_GET[employeess]',
												 total = '$total'
												 WHERE bracket = '$_GET[bracket]'");
    echo "data updated";												 
   }   
      
    
?>

