<?php
session_start();
if(!isset($_SESSION['Username'])){
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
</style><form action="" method="get">
<table>
	<tr>
    	<td><strong>Search</strong></td><td></td>
    </tr>
    <tr>
    	<td>Employee ID</td><td>First Name</td><td>Last Name</td>
    </tr>
    <tr>
    	<td><input type="text" name="employeeid" /></td>
        <td><input type="text" name="firstname" /></td>
        <td><input type="text" name="lastname" /></td>
    </tr>
    <tr>
<select name="tl">
<option value = "0"></option>
<?php
$getlist=mysqli_query($con,"select * from team_supervisor");
while($rowlist=mysqli_fetch_array($getlist))
{
?>
 <option value="<?php echo $rowlist['employeeid']?>"><?php echo $rowlist['TeamSupervisor']?></option>
    
<?php
}
?>
</select>    
    </tr>
    <tr>
    	<td colspan="3" align="right">
        (Leave all blank to view all)
        <input type = "hidden" name = "searching" value="1" />
        <input type="submit" name="search" value="Search" /></td>
    </tr>
</table>

</form>

<?php

if($_POST['todo']=='updateemployeeschedule')
{
	$updatescheds="update prlemployeemaster set schedule='".$_POST['groupssched']."' where employeeid='".$_POST['employeeid1']."'";
	//echo $updatescheds;
	mysqli_query($con,$updatescheds);
	echo '<font style="color:#FF3333; size:14px;">Schedule of Employee '.$_POST['employeeid1'].' has been changed!</font>';
	echo "<p>&nbsp;</p>";
}


?>

<?php
	
 if($_GET['searching']=='1')
  {    
?>
<table border="1" cellpadding="5">
<tr align="center">
	<td><strong>Emplyee ID</strong></td>
    <td><strong>Last Name</strong></td>
    <td><strong>First Name</strong></td>
    <td><strong>Middle Name</strong></td>
    <td><strong>Schedule(24H)</strong></td>
</tr>
<?php
if($_GET['tl'] != '0')
{
	$getteam=mysqli_query($con,"select * from teamassignment WHERE teamlead = '".$_GET['tl']."'");
	while($rowgetteam=mysqli_fetch_array($getteam))
	{
$getemplyees=mysqli_query($con,"select * from prlemployeemaster WHERE employeeid = '".$rowgetteam['employeeid']."' ORDER BY lastname asc");
$row='0';
         while($rowgetemplyees=mysqli_fetch_array($getemplyees)){
          $row = $row + '1';	
?>

<tr>
	<td><?php echo $rowgetemplyees['employeeid'];?></td>
    <td><?php echo $rowgetemplyees['lastname'];?></td>
    <td><?php echo $rowgetemplyees['firstname'];?></td>
    <td><?php echo $rowgetemplyees['middlename'];?></td>
    <td>    <form method="post" name="groupschedform.<?php echo $xsub?>">
	<select name="groupssched" onChange="this.form.submit()">
	<?php
   $getgroupsched=mysqli_query($con,"SELECT * FROM groupschedule ORDER BY groupschedulename asc");
   
	while($rowsched=mysqli_fetch_array($getgroupsched)){
	?>
    	<option value = "<?php echo $rowsched['groupschedulename']; ?>"<?php if($rowsched['groupschedulename']==$rowgetemplyees['schedule']){ echo 'selected="selected"'; } ?> ><?php echo $rowsched['groupschedulename']?> (<?php echo $rowsched['starttime']?>-<?php echo $rowsched['endtime']?>)</option>
    <?php
	}
	?>
    <input type="hidden" name="employeeid1" value="<?php echo $rowgetemplyees['employeeid']?>" />
    <input type="hidden" name="todo" value="updateemployeeschedule" />
   </select>
   </form></td>
    

</tr>

 	 	 	
<?php 		  
		
          }
	}
	
}
else
{
$getemplyees=mysqli_query($con,"select * from prlemployeemaster WHERE employeeid LIKE '%".$_GET['employeeid']."%' and lastname LIKE '%".$_GET['lastname']."%'  and firstname LIKE '%".$_GET['firstname']."%' AND active = '0' ORDER BY lastname asc");
$row='0';
while($rowgetemplyees=mysqli_fetch_array($getemplyees)){
$row = $row + '1';
?>

<tr>
	<td><?php echo $rowgetemplyees['employeeid'];?></td>
    <td><?php echo $rowgetemplyees['lastname'];?></td>
    <td><?php echo $rowgetemplyees['firstname'];?></td>
    <td><?php echo $rowgetemplyees['middlename'];?></td>
    <td>    <form method="post" name="groupschedform.<?php echo $xsub?>">
	<select name="groupssched" onChange="this.form.submit()">
	<?php
   $getgroupsched=mysqli_query($con,"SELECT * FROM groupschedule ORDER BY groupschedulename asc");
   
	while($rowsched=mysqli_fetch_array($getgroupsched)){
	?>
    	<option value = "<?php echo $rowsched['groupschedulename']; ?>"<?php if($rowsched['groupschedulename']==$rowgetemplyees['schedule']){ echo 'selected="selected"'; } ?> ><?php echo $rowsched['groupschedulename']?> (<?php echo $rowsched['starttime']?>-<?php echo $rowsched['endtime']?>)</option>
    <?php
	}
	?>
    <input type="hidden" name="employeeid1" value="<?php echo $rowgetemplyees['employeeid']?>" />
    <input type="hidden" name="todo" value="updateemployeeschedule" />
   </select>
   </form></td>
    

</tr>

 	 	 	
<?php 
} //closing for while query

}

} //closing for " if searching ==1"
?>
</table>
