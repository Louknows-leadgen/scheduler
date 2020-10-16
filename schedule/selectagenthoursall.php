<?php
session_start();
include('db_connect.php');
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


</head>

<body>

<?php
//$teamleadid=$_SESSION['employeeid'];
//echo $teamleadid;
/*$gettl=mysqli_query($con,"select * from team_supervisor where employeeid='".$teamleadid."'");
while($rowtl=mysqli_fetch_array($gettl)){
	echo "<b><font size='6'>".$rowtl['TeamSupervisor']."'s Team</font><b><br><br>";
	}*/
	
	if($_GET['month']=='')
	{
	$monthtoday=date('m');	
	}
	else{
		$monthtoday=$_GET['month'];
		}
		
	if($_GET['year']=='')
	{
	$yeartoday=date('Y');	
	}
	else{
		$yeartoday=$_GET['year'];
		}
		
	if($_GET['payperiod']=='')
	{
	$payperiod='10';	
	}
	else{
		$payperiod=$_GET['payperiod'];
		}	




?>
<form method="GET" name="payperioddaw">
<table>
<tr>
<td>Pay Period:</td>
<td>
    	<select name="month" onchange="document.payperioddaw.submit()">
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
            
            <select name="payperiod"  onchange="document.payperioddaw.submit()">
            	<option></option>
            	<option value="10" <?php if($payperiod=='10'){ echo 'selected="selected"';} ?>>10</option>
                <option value="25" <?php if($payperiod=='25'){ echo 'selected="selected"';} ?>>25</option>
            </select>
            </td>
    		<td>
            
            <select name="year"  onchange="document.payperioddaw.submit()">
            	<option></option>
            	<option value="2016" <?php if($yeartoday=='2016'){ echo 'selected="selected"';} ?>>2016</option>
                <option value="2017" <?php if($yeartoday=='2017'){ echo 'selected="selected"';} ?>>2017</option>
                <option value="2018" <?php if($yeartoday=='2018'){ echo 'selected="selected"';} ?>>2018</option>
                <option value="2019" <?php if($yeartoday=='2019'){ echo 'selected="selected"';} ?>>2019</option>
            </select>
        
        </td>

</tr>
</table>
<br />
</form>
<table border="1" cellpadding="5">
<tr bgcolor="#666666">
	<td><strong>Employee ID</strong></td>
    <td><strong>First Name</strong></td>
    <td><strong>Last Name</strong></td>
    <td><strong>Supervisor</strong></td>
    <!--<td><strong>Month</strong></td>
    <td><strong>Pay Period</strong></td>
    <td><strong>Year</strong></td>
    <td><strong>View</strong></td>!-->
    <td><strong>Approved?</strong></td>
</tr>
<?php


//$getemployee=mysqli_query($con,"select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster,teamassignment where prlemployeemaster.costcenterid='AGT' and  prlemployeemaster.employeeid in (select teamassignment.employeeid from teamassignment where teamlead='".$teamleadid."') group by prlemployeemaster.employeeid");
//and teamassignment.teamlead='".$teamleadid."'
$getemployee="select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,teamassignment.teamlead from prlemployeemaster,teamassignment where teamassignment.employeeid=prlemployeemaster.employeeid and prlemployeemaster.active='0'  group by prlemployeemaster.employeeid order by teamassignment.teamlead";
//echo $getemployee;

$getemployee=mysqli_query($con,$getemployee);
$x=0;
$gettotalcount=mysqli_num_rows($getemployee);
if($gettotalcount>0)
{
while($rowemployee=mysqli_fetch_array($getemployee)){
	if($x%=2)
	{
		//$bgcolor="#999999";
	}
	else{
		$bgcolor="white";
	}

		$getteam=mysqli_query($con,"select * from team_supervisor where employeeid='".$rowemployee['teamlead']."'");
		while($rowteam=mysqli_fetch_array($getteam)){
			$TeamSupervisor=$rowteam['TeamSupervisor'];
			$colors=$rowteam['colors'];
			}
		?> 	
        <!-- onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"  !-->
<tr bgcolor="<?php echo $colors?>" >
	<td><?php echo $rowemployee['employeeid']?></td>
    <td><?php echo $rowemployee['firstname']?></td>
    <td><?php echo $rowemployee['lastname']?></td>
    <td>
    	<?php
		echo $TeamSupervisor;
			
		?>
    </td>
   <!-- <script>
    function target_popup(form) {
    window.open('', 'getdate<?php echo $rowemployee['employeeid']?>', 'width=1280,height=1000,resizeable,scrollbars');
    form.target = 'getdate<?php echo $rowemployee['employeeid']?>';
	}
	</script>
    <form name="getdate<?php echo $rowemployee['employeeid']?>" method="post"  action="viewhours.php" onsubmit="target_popup(this)">
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
            	<option value="10" <?php if($payperiod=='10'){ echo 'selected="selected"';} ?>>10</option>
                <option value="25" <?php if($payperiod=='25'){ echo 'selected="selected"';} ?>>25</option>
            </select>
            </td>
    		<td>
            
            <select name="year">
            	<option></option>
            	<option value="2010" <?php if($yeartoday=='2016'){ echo 'selected="selected"';} ?>>2016</option>
                <option value="2011" <?php if($yeartoday=='2017'){ echo 'selected="selected"';} ?>>2017</option>
                <option value="2011" <?php if($yeartoday=='2018'){ echo 'selected="selected"';} ?>>2018</option>
                <option value="2011" <?php if($yeartoday=='2019'){ echo 'selected="selected"';} ?>>2019</option>
            </select>
        
        </td>
      <td> <input type="image" src="images/zoom.png"></td>!-->
       <td>
       <?php
	   $paydates=$yeartoday."-".$monthtoday."-".$payperiod;
       $checkapprove=mysqli_query($con,"select * from approved_payperiods where payperiod='".$paydates."' and employeeid='".$rowemployee['employeeid']."' and TLapproved='1'");
	   $numapprove=mysqli_num_rows($checkapprove);
	   if($numapprove>='1'){
       ?>
	   <img src="images/Check-icon2.png" />
       <?php
	   }
	   else{
	   ?>
       <img src="images/Delete-icon.png" />
        <?php } ?></td>
        </form>
</tr>
<?php
$x++;
}
}
else{
	?>
    <tr><td colspan="8" align="center">No data yet</td></tr>
<?php
	}
?>
</table>

</body>
</html>