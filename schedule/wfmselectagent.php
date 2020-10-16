<?php
session_start();
include('db_connect.php');
//echo $_SESSION['employeeid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >
<title>Agent Select</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
<STYLE>
<!--
  tr { background-color: #DDDDDD}
  .initial { background-color: #DDDDDD; color:#000000 }
  .normal { background-color: #CCCCCC }
  .highlight { background-color: #8888FF }
//-->
</style>

</head>

<body>
<form name="selecttl" method="post">
Select TL/Supervisor: <select name="tl" onchange="document.selecttl.submit()">
<option></option>
<?php
$getlist=mysqli_query($con,"select * from team_supervisor");
while($rowlist=mysqli_fetch_array($getlist))
{
?>
 <option value="<?php echo $rowlist['employeeid']?>" <?php if($_POST['tl']==$rowlist['employeeid']){ echo 'selected="selected"';} ?>><?php echo $rowlist['TeamSupervisor']?></option>
    
<?php
}
?>
</select>
</form><br />
<br />

<table border="1" cellpadding="5">
<tr bgcolor="#666666">
	<td><strong>Employee ID</strong></td>
    <td><strong>First Name</strong></td>
    <td><strong>Last Name</strong></td>
    <td><strong>Month</strong></td>
    <td><strong>Pay Period</strong></td>
    <td><strong>Year</strong></td>
    <td><strong>View</strong></td>
</tr>
<?php
$monthtoday=date('m');
$yeartoday=date('Y');
//echo "select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,prlemployeemaster.schedule from prlemployeemaster,teamassignment where prlemployeemaster.costcenterid='AGT' and  prlemployeemaster.employeeid in  (select teamassignment.employeeid from teamassignment where teamlead='".$_POST['tl']."') group by prlemployeemaster.employeeid";
$getemployee=mysqli_query($con,"select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,prlemployeemaster.schedule from prlemployeemaster,teamassignment where prlemployeemaster.active='0' and  prlemployeemaster.employeeid in  (select teamassignment.employeeid from teamassignment where teamlead='".$_POST['tl']."') group by prlemployeemaster.employeeid");
//
$x=0;
$agentcount=mysqli_num_rows($getemployee);
if($agentcount>0){

while($rowemployee=mysqli_fetch_array($getemployee)){
	if($x%=2)
	{
		$bgcolor="#999999";
	}
	else{
		$bgcolor="white";
	}
?>
	 	
<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" >
	<td><?php echo $rowemployee['employeeid']?></td>
    <td><?php echo $rowemployee['firstname']?></td>
    <td><?php echo $rowemployee['lastname']?></td>
    <script>
    function target_popup(form) {
    window.open('', 'getdate<?php echo $rowemployee['employeeid']?>', 'width=1280,height=1000,resizeable,scrollbars');
    form.target = 'getdate<?php echo $rowemployee['employeeid']?>';
	}
	</script>
    <form name="getdate<?php echo $rowemployee['employeeid']?>" method="post"  action="calendar.php" onsubmit="target_popup(this)">
   
   <input type="hidden" name="schedule" value="<?php echo $rowemployee['schedule']?>" />
    <input type="hidden" name="employeeid" value="<?php echo $rowemployee['employeeid']?>" />
    <input type="hidden" name="agentname" value="<?php echo $rowemployee['firstname']?>" />
    <input type="hidden" name="agenltname" value="<?php echo $rowemployee['lastname']?>" />
    <td>
    	<select name="month">
        		<option></option>
            	<option value="01" <?php if($monthtoday=='01'){ echo 'selected="selected"';} ?>>January</option>
                <option value="02" <?php if($monthtoday=='02'){ echo 'selected="selected"';} ?>>Febuary</option>
                <option value="03" <?php if($monthtoday=='03'){ echo 'selected="selected"';} ?>>March</option>
                <option value="04" <?php if($monthtoday=='04'){ echo 'selected="selected"';} ?>>April</option>
                <option value="05" <?php if($monthtoday=='05'){ echo 'selected="selected"';} ?>>May</option>
                <option value="06" <?php if($monthtoday=='06'){ echo 'selected="selected"';} ?>>June</option>
                <option value="07" <?php if($monthtoday=='07'){ echo 'selected="selected"';} ?>>July</option>
                <option value="08" <?php if($monthtoday=='08'){ echo 'selected="selected"';} ?>>August</option>
                <option value="09" <?php if($monthtoday=='09'){ echo 'selected="selected"';} ?>>September</option>
                <option value="10" <?php if($monthtoday=='10'){ echo 'selected="selected"';} ?>>October</option>
                <option value="11" <?php if($monthtoday=='11'){ echo 'selected="selected"';} ?>>November</option>
                <option value="12" <?php if($monthtoday=='12'){ echo 'selected="selected"';} ?>>December</option>
            </select>
            </td>
   			<td>
            
            <select name="payperiod">
            	<option></option>
            	<option value="10">10</option>
                <option value="25">25</option>
            </select>
            </td>
    		<td>
            <select name="year">
            	<option></option>
            	<option value="2020" <?php if($yeartoday=='2020'){ echo 'selected="selected"';} ?>>2020</option>
                <option value="2021" <?php if($yeartoday=='2021'){ echo 'selected="selected"';} ?>>2021</option>
                <option value="2022" <?php if($yeartoday=='2022'){ echo 'selected="selected"';} ?>>2022</option>
                <option value="2023" <?php if($yeartoday=='2023'){ echo 'selected="selected"';} ?>>2023</option>
            </select>
        
        </td>
       <td> <input type="image" src="images/zoom.png"></td>
        </form>
</tr>
<?php
$x++;
}
}
else{
	?>
    <tr>
    <td colspan="7" align="center">Please select TL/Supervisor</td>
    </tr>
    <?php
	}
?>
</table>

</body>
</html>
