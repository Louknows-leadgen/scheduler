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
<table width="589" border="1">
<tr align="center">
	<td width="35"><div align="center"><strong>Bonus ID</strong></div></td>
    <td width="209"><div align="center"><strong>Bonus Description</strong></div></td>
    <td width="209"><div align="center"><strong>Bonus Value</strong></div></td>    
    <td width="106"><div align="center"><strong>Taxable</strong></div></td>
    <td width="117"><div align="center"><strong>Payout</strong></div></td>
    <td width="156"><div align="center"><strong>Occurance</strong></div></td>
    <td width="117"><div align="center"><strong>Edit</strong></div></td>
    <td width="156"><div align="center"><strong>Delete</strong></div></td>
</tr>
<?php 	$result = mysqli_query($con,"SELECT * from prlothinctable ORDER BY othincdesc asc");
        while($row = mysqli_fetch_array($result))
		{
?>

<tr>
<td><div align="center">
  <?php echo $row['othincid']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['othincdesc']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['othincvalue']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['taxable']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['payout']; ?>
</div></td>
<td><div align="center">
  <?php echo $row['occurance']; ?>
</div></td>
    <td align="center"><a href="?todo=3&&othincid=<?php echo $row['othincid']; ?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
    <td align="center"><a href="?todo=4&&othincid=<?php echo $row['othincid']; ?>" alt="Delete" name="Delete" onClick="return confirm('Confirm Delete?')" ><img src="images/close.png" width="20"  /></a></td>    
</tr>

<?php
         }
?>

</table>
<form method = "get" action = "" name = "tax">

  <p>
    <input type = "submit" name = "add" value = "Add New Bonus" />
    <input type = "hidden" name = "todo" value = "1">
    
        </p>
</form>
<?php

}
else if($_GET['todo'] == '1')
  {

   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addbonus'>";
   echo "<td>Bonus Description: </td>";
   echo "<td><input type = 'text' name = 'othincdesc' size = '43'></td></tr>";
   echo "<td>Bonus Value: </td>";
   echo "<td><input type = 'text' name = 'othincvalue' size = '15'></td></tr>";
   echo "<td>Taxable: </td>";   
   echo "<td><select name='taxable'>
				      <option value='Taxable'>Taxable</option>
				      <option value='Non-taxable'>Non-Taxable</option>
				      </select><td> </tr>";
   echo "<td>Payout: </td>";   
   echo "<td><select name='payout'>
                      <option value='0'>0</option>
				      <option value='10th'>10th</option>
				      <option value='25th'>25th</option>
				      <option value='10th,25th'>10th,25th</option>
				      </select><td> </tr>";  
   echo "<td>Occurance: </td>";   
   echo "<td><select name='occurance'>
				      <option value='Monthly'>Monthly</option>
				      <option value='Bi-Monthly'>Bi-Monthly</option>
				      <option value='Optional'>Optional</option>
				      </select><td> </tr>";    
   echo "<input type = 'hidden' name = 'todo' value = '2'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Add New Bonus'></td>";
   echo "</table>";
   }
else if($_GET['todo'] == '2')
   { 
  
     $sql="INSERT INTO prlothinctable (othincdesc, othincvalue, payout, taxable, occurance)
     VALUES
     ('$_GET[othincdesc]','$_GET[othincvalue]','$_GET[payout]','$_GET[taxable]','$_GET[occurance]')";
	                       if (!mysqli_query($con,$sql,$con))
                         {
                          die('Error: ' . mysqli_connect_error());
                         }	
	 echo "New Bonus Added!";								   
   }   
   
else if($_GET['todo'] == '3')
  {

	$result = mysqli_query($con,"SELECT * from prlothinctable WHERE othincid = '$_GET[othincid]'");
	$row = mysqli_fetch_array($result);  
   echo "<table width='450' border='1'>";
   echo "<form method = 'get' action = '' name = 'addnewstatus'>";
   echo "<td width = '150'>Bonus ID: </td>";
   echo "<td>"; echo $row['othincid']; echo "</td> </tr>";
   echo "<td>Bonus Description: </td>";
   echo "<td><input type = 'text' name = 'othincdesc' value = '$row[othincdesc]' size = '43'></td></tr>";
   echo "<td>Bonus Value: </td>";
   echo "<td><input type = 'text' name = 'othincvalue' value = '$row[othincvalue]' size = '43'></td></tr>";
   echo "<td>Taxable: </td>"; 
   echo "<td><select name='taxable'>
                      <option value='$row[taxable]'>$row[taxable]</option>
				      <option value='Taxable'>Taxable</option>
				      <option value='Non-Taxable'>Non-Taxable</option>
				      </select><td> </tr>";        
   echo "<td>Payout: </td>";   
   echo "<td><select name='payout'>
                      <option value='$row[payout]'>$row[payout]</option>
					  <option value='0'>0</option>
				      <option value='10th'>10th</option>
				      <option value='25th'>25th</option>
				      <option value='10th,25th'>10th,25th</option>
				      </select><td> </tr>";
   echo "<td>Occurance: </td>";  
   echo "<td><select name='occurance'>
                      <option value='$row[occurance]'>$row[occurance]</option>
				      <option value='Monthly'>Monthly</option>
				      <option value='Bi-Monthly'>Bi-Monthly</option>
				      <option value='Optional'>Optional</option>
				      </select><td> </tr>";      					  
   echo "<input type = 'hidden' name = 'todo' value = '35'>";
   echo "<input type = 'hidden' name = 'othincid' value = '$row[othincid]'>";   
   echo "<td>&nbsp;</td><td><input type = 'submit' name = 'newstatus' value = 'Update Bonus'></td>";
   echo "</table>";
   }
else if($_GET['todo'] == '35')
  {

    mysqli_query($con,"UPDATE prlothinctable SET othincdesc = '$_GET[othincdesc]',
						   othincvalue = '$_GET[othincvalue]',
					           payout = '$_GET[payout]',
						   taxable = '$_GET[taxable]',
						   occurance = '$_GET[occurance]'
						WHERE othincid = '$_GET[othincid]'");
	if($_GET['taxable'] == 'Taxable')
	{$taxableupdate = '1';}
	else{$taxableupdate = '0';}
    mysqli_query($con,"UPDATE prlotherincassign SET othincdescription = '$_GET[othincdesc]', 
					       taxable = '$taxableupdate',
						   occurance = '$_GET[occurance]',
						   payout = '$_GET[payout]'						   
						WHERE othincid = '$_GET[othincid]'");						
    echo "data updated";												 
   }   
      


else if($_GET['todo'] == '4')
  {

     mysqli_query($con,"DELETE FROM prlothinctable WHERE othincid = '$_GET[othincid]'");
	 mysqli_query($con,"DELETE FROM prlotherincassign WHERE othincid = '$_GET[othincid]'");
     echo " Deleted!!!";									 
   }   
      
?>

