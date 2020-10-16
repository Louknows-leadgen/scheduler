<?php
session_start();
ob_start();
//echo "this ".$_SESSION['test'];
include('db_connect.php');
$pmonth=$_POST['month'];
$ppayperiod=$_POST['payperiod'];
$pyear=$_POST['year']; 
$approve=0;
//echo "select * from approved_payperiods where payperiod='".$pyear."-".$pmonth."-".$ppayperiod."' and employeeid='".$_POST['employeeid']."'";
$checkifapproved=mysqli_query($con,"select * from approved_payperiods where payperiod='".$pyear."-".$pmonth."-".$ppayperiod."' and employeeid='".$_POST['employeeid']."'");
$checknum=mysqli_num_rows($checkifapproved);
if($checknum>=1){
	$message="This has already been approved";
	$approve='1';
	}
//$month=10;
//$startday=16; //1
//$year=2010;

//echo $lastdays;

#echo generate_calendar($year, $month, $days,$day_name_length,$month_href,$first_day,$pn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$_POST['employeeid']?> <?=$_GET['employeeid']?> - <?=$_POST['agentname']?> <?=$_POST['agenltname']?> <?=$_GET['agentname']?> <?=$_GET['agenltname']?>'s Schedule</title>
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>

<script type="text/javascript" src="js/jquery.ui.js"></script>
<? if($approve!='1'){ ?>
<script type="text/javascript" src="js/jquery.editinplace.js"></script>
<? } ?>
<script type="text/javascript" src="js/anytime.js"></script>
<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<link rel="stylesheet" href="css/anytime.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<style>
.present{
	background-color:white;
	color:black;
	}
.absent{
	background-color:red;
	color:black
	}	
.ot{
	background-color:yellowgreen;
	color:black;
	}
.restday{
	background-color:#CCCCCC; color:#666666;
	}	
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
</style>

</head>
<body>
<?
if(($_POST['month']!='' && $_POST['year']!='' && $_POST['employeeid']!='' && $_POST['payperiod']!='')||($_GET['month']!='' && $_GET['year']!='' && $_GET['employeeid']!='' && $_GET['payperiod']!='')){
	if($_GET['employeeid']!='')
	{
		
$month=$_GET['month'];
$year=$_GET['year'];
$userid=$_GET['employeeid'];

if($_GET['payperiod']=='10'){ 
	$startday=16;
	
	if($month=='01')
	{
		$month='12';
		$year=$year-1;
		}
	else{
		$month=$month-1;
		}	
		$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$enddays=$days_in_month;
	}
else{
	$startday=1;
	/*if($days_in_month=='31')
	{
		$deducteddays='16';
		}
	else if($days_in_month=='30')
	{
		$deducteddays='15';
		}
	else if($days_in_month=='29')
	{
		$deducteddays='14';
		}
	else{
		$deducteddays='13';
		}	
		$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);*/
	$enddays=15;
	}
		}
		else{
			
$getscheduletime=mysqli_query($con,"SELECT * FROM `groupschedule` where groupschedulename='".$schedule."'");
				while($rowskedtime=mysqli_fetch_array($getscheduletime)){
					$starttime=$rowskedtime['starttime'];
					$endtime=$rowskedtime['endtime'];
					$otherday=$rowskedtime['otherday'];
					echo $otherday;
					}	 				
			
			$schedule=$_POST['schedule'];
$month=$_POST['month'];
$year=$_POST['year'];
$userid=$_POST['employeeid'];

if($_POST['payperiod']=='10'){ 
	$startday=16;
	
	if($month=='01')
	{
		$month='12';
		$year=$year-1;
		}
	else{
		$month=$month-1;
		
		}	
	$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$enddays=$days_in_month;
		//echo $enddays;
	}
else{
	$startday=1;
	/*$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
	if($days_in_month=='31')
	{
		$deducteddays='16';
		}
	else if($days_in_month=='30')
	{
		$deducteddays='15';
		}
	else if($days_in_month=='29')
	{
		$deducteddays='14';
		}
	else{
		$deducteddays='13';
		}	
	$enddays=$days_in_month-$deducteddays;*/
	$enddays=15;
	//echo $enddays;
	}	
	
		}
//$userid=1000057;
//$userid=1000091;

//echo $days_in_month;
//echo "<br>";

?>
<font color="#00CC00" size="+1"><?=$message?></font>
<table border="1" style="border-style:solid;" cellpadding="3">
 
<tr bgcolor="#999999"><td colspan="9"><strong><?=$_POST['employeeid']?> <?=$_GET['employeeid']?> - <?=$_POST['agentname']?> <?=$_POST['agenltname']?> <?=$_GET['agentname']?> <?=$_GET['agenltname']?></strong></td></tr>
<tr bgcolor="#999999"><td colspan="9"><strong><?=date('F',mktime(0, 0, 0, $month, 1, $year))?> <?=$startday?>-<?=$enddays?></strong></td></tr>
<tr style="text-align: center"  bgcolor="#999999">
<td colspan="2"><strong>Day</strong></td>
<td  ><strong>Status</strong></td>
<td width="150"><strong>Early Time</strong></td>
<td width="150"><strong>Start Shift</strong></td>
<!--<td width="150"><strong>Out</strong></td>
<td width="150"><strong>IN</strong></td>!-->
<td width="150"><strong>End Shift</strong></td>
<td width="150"><strong>OT Start</strong></td>
<td width="150"><strong>OT End</strong></td>
       
<td width="150"><strong>Shift</strong></td>

</tr >
<?
for($x=$startday;$x<=$enddays;$x++){
	
	$day=date('D',mktime(0, 0, 0, $month, $x, $year));
	
	$getdata2="select * from timelog where userid='".$userid."' and dates='".$year."-".$month."-".$x."' order by dates asc";
	//echo $getdata2."<br>";
	$getdata=mysqli_query($con,$getdata2);
	$numrowsdaws=mysqli_num_rows($getdata);
	if ($numrowsdaws <= 0)
		{
			echo "<font color='red'><b>Sorry... You don't get your pay this pay period... Please ask assistance from your TLs/Supervisors.. Thank you!<b></font>";
			exit();
		
		
		}
	else{
			while($rowgetdata=mysqli_fetch_array($getdata))
			{
				//$getempployeescked=mysqli_query($con,"select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and RFID='".$userid."'");
				//while($employeesked=mysqli_fetch_array($getempployeescked)){
				//if($employeesked[$day]=='1')
				//{
					$status=$rowgetdata['status'];
				//	}
				//else{
				//	$status="OT";
				//	}	
			//	}
				?>
                <tr <? if($status=='Present'){ echo 'class="present"';} 
				else if($status=='Absent'){ echo 'class="absent"';} 
				else if($status=='Restday'){ echo 'class="restday"';} 
				else { echo 'class="ot"';}?> id="statuschanger_<?=$x?>"  height="40" >
                    <td><strong>
                    <?=$day?>
                    </strong></td>
                    <td><?=$x?></td>
                    <td><p class="edit_status_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_editstatus"><?=$status?></p></td>
                	<td style="text-align: center">
					<?
					
                   // $earlytimedate=explode(" ",$rowgetdata['earlytimedate']);
					?>
                    <font class="edit_earlydatetime_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeearlydatetime"><?=$rowgetdata['earlytimedate']?></font>
                    <!--<font class="edit_earlydate_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeearlydate"><?=$earlytimedate[0]?></font>                    <font class="edit_earlytime_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeearlytime"><?=$earlytimedate[1]?></font>!-->
                   

	
                    </td>
                    <td style="text-align: center">
					<font class="edit_startshift_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changestartshift"><?=$rowgetdata['startshift']?></font>
				  </td>
                  <!--
                  <td style="text-align: center">
					<font class="edit_startlunch_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changelunchstart"><?=$rowgetdata['startlunch']?></font>
				  </td>
                  <td style="text-align: center"><font class="edit_endlunch_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeendlunch"><?=$rowgetdata['endlunch']?></font></td>
                  !-->
                  <td style="text-align: center"><font class="edit_endshift_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeendshift"><?=$rowgetdata['endshift']?></font></td>
                  <td style="text-align: center"><font class="edit_obstart_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeotstart"><?=$rowgetdata['otstart']?></font></td>
                    <td style="text-align: center"><font class="edit_obend_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeotend"><?=$rowgetdata['otend']?></font></td>
                    
                   <?
                
					?> <td><?=$rowgetdata['thisdaysshift']?></td>
                    
               	</tr>
             <?	
			
			
			}
		
		}	
	
	}
?>

</table>
<? } 
else{
	echo "Please select month, payperiod and year";
	}
	
	print_r($datesshit);
	echo "<br>";
	print_r($datesshit2);

?>
</body></html>

