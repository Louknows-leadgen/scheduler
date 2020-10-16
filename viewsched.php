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
include("db_connect.php");
if($_POST['shiftname']!='')
{
	$groupschedulename=$_POST['shiftname'];
	$starttime=$_POST['shiftstarthour'].":".$_POST['shiftstartmin'].":00";
	$lunchstarting=$_POST['lunchstarthour'].":".$_POST['lunchstartmin'].":00";
	$lunchhour = $_POST['lunchstarthour'] + 1;
	$lunchending=$lunchhour.":".$_POST['lunchstartmin'].":00";
	$endtime=$_POST['shiftendhour'].":".$_POST['shiftendmin'].":00";
	$prelunch = $_POST['lunchstarthour'] - $_POST['shiftstarthour'] ;
	if($prelunch< 0 )
	{
		$prelunch = $prelunch + 24;
	}
	$prelunchmin = $_POST['lunchstartmin']/60;
	$prelunch = $prelunch.".".$prelunchmin;
	
	$Mon=$_POST['Mon']; 
	$Tue=$_POST['Tue']; 
	$Wed=$_POST['Wed']; 
	$Thu=$_POST['Thu']; 
	$Fri=$_POST['Fri']; 
	$Sat=$_POST['Sat']; 
	$Sun=$_POST['Sun']; 
	$Holiday=$_POST['Holiday'];
	$updatesched="update groupschedule set groupschedulename='$groupschedulename',
	starttime='$starttime',
	endtime='$endtime', 
	lunchstart='$lunchstarting',
	lunchend='$lunchending',
	prelunch='$prelunch', 
	Mon='$Mon', 
	Tue='$Tue', 
	Wed='$Wed', 
	Thu='$Thu', 
	Fri='$Fri', 
	Sat='$Sat', 
	Sun='$Sun', 
	Holiday='$Holiday' where id='".$_POST['id']."'";
	//echo $updatesched;
	mysqli_query($con,$updatesched);

$mess='<p style="background-color:yellow; font-size:14px; color:Black""><b>'.$groupschedulename.' Successfully Updated</b></p>';
	
}

if($_GET['task']=="deletesched")
{

	mysqli_query($con,"DELETE FROM groupschedule WHERE id = '".$_GET['schedid']."'");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VectorBPO Payroll> View Schedule</title>
<!-- <link rel="stylesheet" type="text/css" href="css/styles.css" /> -->


</head>

<body>
<font style="background-color:#FF3;color:#000; size:14px;"><?php echo $mess; ?></font>

<table border="1" cellpadding="3" bgcolor="#FFFFFF">
<td colspan="13" class="pagetitle"> <div align="center"><strong>View/Edit/Delete Schedule</strong></div></td>
<tr>
	<td>Shift Name</td><td>Time Start</td><td>Lunch Start</td><td>Lunch End</td><td>Time End</td>
    <td>Mon</td>
    <td>Tue</td> 
    <td>Wed</td>
    <td>Thu</td>
    <td>Fri</td>	
    <td>Sat</td> 
    <td>Sun</td>	 
    <td>Holiday</td>	 	 	 	 	
	<td>Edit</td>
	<td>Delete</td>
</tr>
<?php
$getgroupsched=mysqli_query($con,"SELECT * FROM groupschedule ORDER BY groupschedulename asc");
while($rowsched=mysqli_fetch_array($getgroupsched)){
?>
<tr>
	<td align="center"><?php echo $rowsched['groupschedulename']; ?></td>
    <td><?php echo $rowsched['starttime']; ?></td>
    <td><?php echo $rowsched['lunchstart']; ?></td>
    <td><?php echo $rowsched['lunchend']; ?></td>
    <td><?php echo $rowsched['endtime']; ?></td>
    <td><input type="checkbox"  <?php if($rowsched['Mon']=='1'){ echo 'checked="checked"';} ?> name="Mon" disabled="disabled"/></td>
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Tue']=='1'){ echo 'checked="checked"';} ?>></td> 
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Wed']=='1'){ echo 'checked="checked"';} ?>></td>
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Thu']=='1'){ echo 'checked="checked"';} ?>></td>
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Fri']=='1'){ echo 'checked="checked"';} ?>></td>	
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Sat']=='1'){ echo 'checked="checked"';} ?>></td> 
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Sun']=='1'){ echo 'checked="checked"';} ?>></td>	 
    <td><input type="checkbox" disabled="disabled" <?php if($rowsched['Holiday']=='1'){ echo 'checked="checked"';} ?>></td>
    <td align="center"><a href="?task=editsched&schedid=<?php echo $rowsched['id']; ?>" alt="Edit" name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
    <td align="center"><a href="?task=deletesched&schedid=<?php echo $rowsched['id']; ?>" alt="Delete" name="Delete"><img src="images/close.png" width="20"  /></a></td>
</tr>
<?php
	}
?>
</table>

<?php
if(isset($_GET['task']) && $_GET['task']=='editsched')
{
$getsched="select * from groupschedule where id='".$_GET['schedid']."'";
//echo $getsched;
$getsched=mysqli_query($con,$getsched);
while($rowsched=mysqli_fetch_array($getsched)){
$rowstarttime=explode(":",$rowsched['starttime']);
$lunchstarttime=explode(":",$rowsched['lunchstart']);
$rowendtime=explode(":",$rowsched['endtime']);
//echo $rowsched['groupschedulename'];
	?>
	<form action="viewsched.php" method="post">
    <input type="hidden" name="id" value="<?php echo $rowsched['id']; ?>" />
	<table border="0" bgcolor="#FFFFFF">
	  <tr>
		<td>Shift Name:</td>
		<td><input type="text" name="shiftname" value="<?php echo $rowsched['groupschedulename']; ?>" /></td>
	  </tr>
	  <tr>
		<td>Shift Start:</td>
		<td>
			<select name="shiftstarthour" />
			<?php
			for($x=0;$x<25;$x++){
				if($x<10){ $x="0".$x; }
			?>
				<option <?php if($rowstarttime[0]==$x) { echo 'selected="selected"';} ?>><?php  echo $x; ?></option>
			<?php
			}
			?>
			</select>
			<select name="shiftstartmin">
				<option <?php if($rowstarttime[1]=='00') { echo 'selected="selected"';} ?>>00</option>
				<option <?php if($rowstarttime[1]=='15') { echo 'selected="selected"';} ?>>15</option>
				<option <?php if($rowstarttime[1]=='30') { echo 'selected="selected"';} ?>>30</option>
				<option <?php if($rowstarttime[1]=='45') { echo 'selected="selected"';} ?>>45</option>
			</select>
		</td>
        <tr>
		<td>Lunch Start:</td>
		<td>
			<select name="lunchstarthour" />
			<?php
			for($x=0;$x<25;$x++){
				if($x<10){ $x="0".$x; }
			?>
				<option <?php if($lunchstarttime[0]==$x) { echo 'selected="selected"';} ?>><?php  echo $x; ?></option>
			<?php
			}
			?>
			</select>
			<select name="lunchstartmin">
				<option <?php if($lunchstarttime[1]=='00') { echo 'selected="selected"';} ?>>00</option>
				<option <?php if($lunchstarttime[1]=='15') { echo 'selected="selected"';} ?>>15</option>
				<option <?php if($lunchstarttime[1]=='30') { echo 'selected="selected"';} ?>>30</option>
				<option <?php if($lunchstarttime[1]=='45') { echo 'selected="selected"';} ?>>45</option>
			</select>
		</td>        
	  </tr>
	  <tr>
		<td>Shift End:</td>
		<td>
        <select name="shiftendhour" />
			<?php
			for($x=0;$x<25;$x++){
				if($x<10){ $x="0".$x; }
			?>
				<option <?php if($rowendtime[0]==$x) { echo 'selected="selected"';} ?>><?php  echo $x; ?></option>
			<?php
			}
			?>
			</select>
			<select name="shiftendmin">
				<option <?php if($rowendtime[1]=='00') { echo 'selected="selected"';} ?>>00</option>
				<option <?php if($rowendtime[1]=='15') { echo 'selected="selected"';} ?>>15</option>
				<option <?php if($rowendtime[1]=='30') { echo 'selected="selected"';} ?>>30</option>
				<option <?php if($rowendtime[1]=='45') { echo 'selected="selected"';} ?>>45</option>
			</select>
	  </td>
	  </tr>
	   <tr>
		<td></td>
		<td>
			<input type="checkbox" name="Mon" value="1" <?php if($rowsched['Mon']=='1') { echo 'checked="checked"';} ?>  /> Mon  
			<input type="checkbox" name="Tue" value="1" <?php if($rowsched['Tue']=='1') { echo 'checked="checked"';} ?>  /> Tue  
			<input type="checkbox" name="Wed" value="1" <?php if($rowsched['Wed']=='1') { echo 'checked="checked"';} ?>  /> Wed  
			<input type="checkbox" name="Thu" value="1" <?php if($rowsched['Thu']=='1') { echo 'checked="checked"';} ?>  /> Thu  
			<input type="checkbox" name="Fri" value="1" <?php if($rowsched['Fri']=='1') { echo 'checked="checked"';} ?>  /> Fri  
			<input type="checkbox" name="Sat" value="1" <?php if($rowsched['Sat']=='1') { echo 'checked="checked"';} ?>  /> Sat  
			<input type="checkbox" name="Sun" value="1" <?php if($rowsched['Sun']=='1') { echo 'checked="checked"';} ?>  /> Sun  
			<input type="checkbox" name="Holiday" value="1" <?php if($rowsched['Holiday']=='1') { echo 'checked="checked"';} ?>  /> Holiday  
		
		</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Update Schedule" value="Update Schedule"></td>
	  </tr>
	 
	</table>
	</form>
	<?php
	}
}


?>
</body>
</html>
