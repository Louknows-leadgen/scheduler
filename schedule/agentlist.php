<?php
include('db_connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >
<title>
Agent Supervisor Assignment
</title>

 
 <style type="text/css">
  a {
   display: block;
   border: 1px solid #aaa;
   text-decoration: none;
   background-color: #fafafa;
   color: #123456;
   margin: 2px;
   clear:both;
  }
  div {
   float:left;
   text-align: center;
   margin: 10px;
  }
  
 body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
</style>
</head>

<?php

	if($_POST['task']=='addtoTL'){
		$transferthis=$_POST['totransfer'];
		if($_POST['totransfer']!='')
		{
		foreach($transferthis as $t){
		//	echo $t.'<br />';
			mysqli_query($con,"insert into teamassignment (teamlead,employeeid) values ('".$_POST['TL']."','".$t."')");
			}
		}
	}
	
	
if($_POST['task']=='removefromTL'){
	$removethis=$_POST['toremove'];
	if($_POST['toremove']!='')
		{
			foreach($removethis as $t){
		//echo $t.'<br />';
			mysqli_query($con,"delete from teamassignment where employeeid='".$t."'");
			//mysqli_query($con,"insert into teamassignment (teamlead,employeeid) values ('".$_POST['TL']."','".$t."')");
			}	
		}
}


//echo $_POST['TL'];
?>
<body>
<p style="background-color:#CCC; font-size:16px"><strong>&nbsp;Assign Agent's Supervisor</strong></p>
<!--
<table>
<tr>
	<td>Employee ID</td>
    <td>First Name</td>
    <td>Last Name</td>
</tr>
<?php
echo "select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster,teamassignment where prlemployeemaster.costcenterid='AGT' and prlemployeemaster.active='0' and  prlemployeemaster.employeeid not in (select teamassignment.employeeid from teamassignment) and group by prlemployeemaster.employeeid";
$getemployee=mysqli_query($con,"select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster,teamassignment where prlemployeemaster.costcenterid='AGT' and prlemployeemaster.active='0' and  prlemployeemaster.employeeid not in (select teamassignment.employeeid from teamassignment) and group by prlemployeemaster.employeeid");

while($rowemployee=mysqli_fetch_array($getemployee)){
?>
	 	
<tr>
	<td><?php echo $rowemployee['employeeid']?></td>
    <td><?php echo $rowemployee['firstname']?></td>
    <td><?php echo $rowemployee['lastname']?></td>
</tr>
<?php
}
?>

</table>

!-->
<form method="post" name="selectTL" id="selectTL">
Select Supervisor: <select name="TL" id="TL" style="height:auto;" onchange="document.selectTL.submit()" >
<option></option>
<?php
$getlist=mysqli_query($con,"select * from team_supervisor");
while($rowlist=mysqli_fetch_array($getlist))
{
?>
<option value="<?php echo $rowlist['employeeid']?>" <?php if($rowlist['employeeid']==$_POST['TL']) { echo 'selected="selected"'; } ?>><?php echo $rowlist['TeamSupervisor']?></option>
<?php
}
?>

</select>
<input type="hidden" name="task" value="selectTL" />
</form>
<br />
<br />

<form method="post" name="agentlistform" id="agentlistform">
<input type="hidden" name="TL" value="<?php echo $_POST['TL']?>" />
 <div>
  <select multiple id="select1" name="totransfer[]" style="width:300px;height:400px;">
  <?php
  if($_POST['TL']!='')
  {
$getemployee=mysqli_query($con,"select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster where prlemployeemaster.active='0' and prlemployeemaster.employeeid not in (select teamassignment.employeeid from teamassignment) group by prlemployeemaster.employeeid order by prlemployeemaster.lastname asc");
while($rowemployee=mysqli_fetch_array($getemployee)){
?>
   <option value="<?php echo $rowemployee['employeeid']?>"><?php echo $rowemployee['employeeid']?> - <?php echo $rowemployee['firstname']?> <?php echo $rowemployee['lastname']?></option>
  <?php
}
  }
  ?>
   
  </select>
 <!-- <a href="#" id="add" onclick="document.agentlistform.submit();">add &gt;&gt;</a>!-->
 <br />
  <input type="hidden" name="task" value="addtoTL" />
<input type="submit" name="addtotl" value="ADD >>" />
 </div>

 </form>
 <form name="removethis" method="post">
 <input type="hidden" name="TL" value="<?php echo $_POST['TL']?>" />
 <div>
 <?php /* if($_POST['TL']!='')
 {
	 
echo $getemployee;
	 }
 */
 ?>
  <select multiple id="select2" name="toremove[]" style="width:300px;height:400px;" >
  <?php
  if($_POST['TL']!='')
  {
$getemployee="select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,teamassignment.teamlead from prlemployeemaster,teamassignment where teamassignment.employeeid=prlemployeemaster.employeeid and teamassignment.teamlead='".$_POST['TL']."' group by prlemployeemaster.employeeid";
$getemployee=mysqli_query($con,$getemployee);
while($rowemployee=mysqli_fetch_array($getemployee)){
	
?>
   <option value="<?php echo $rowemployee['employeeid']?>"><?php echo $rowemployee['employeeid']?> - <?php echo $rowemployee['firstname']?> <?php echo $rowemployee['lastname']?></option>
  <?php
}
  }
  ?>
  </select>
  <br />
<input type="submit" name="removefromtl" value="<< Remove" />
  
 </div>
 <br />
 <br />

 <input type="hidden" name="task" value="removefromTL" />
</form>
</body>
</html>