<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.ui.js"></script>
        <script type="text/javascript" src="js/jquery.editinplace.js"></script>
        <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php
include('db_connect.php');
$month=10;
$year=2010;
$userid=1000057;
$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
//echo $days_in_month;
//echo "<br>";
$lastdays=$days_in_month-15;
//echo $lastdays;

#echo generate_calendar($year, $month, $days,$day_name_length,$month_href,$first_day,$pn);
?>
<table border="1" style="border-style:solid;" cellpadding="5">
<tr><td colspan="9"><strong><?=date('F',mktime(0, 0, 0, $month, 1, $year))?> 1-15</strong></td></tr>
<tr style="text-align: center">
<td colspan="2">Day</td>
<td>Status</td>
<td>Early Time</td>
<td>Start Shift</td>
<td>End Shift</td>
<td>OT Start</td>
<td>OT End</td>
</tr>
<?
for($x=16;$x<=$days_in_month;$x++){
	$day=date('D',mktime(0, 0, 0, $month, $x, $year));
	$getdata="select * from timelog where userid='".$userid."' and dates='".$year."-".$month."-".$x."'";
	$getdata=mysqli_query($con,$getdata);
	if (mysqli_num_rows($getdata) == 0)
		{
			$getempployeescked=mysqli_query($con,"select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and RFID='".$userid."'");
				while($employeesked=mysqli_fetch_array($getempployeescked)){
				if($employeesked[$day]=='1')
				{
					$status="absent";
					}
				else{
					$status="restday";
					}	
				}
			
			?>
            <tr <? if($status=='absent'){ echo 'bgcolor="red" style="color:black"';} else { echo 'bgcolor="#CCCCCC" style="color:#666"';}?>>
                <td><?=$day?></td><td><?=$x?></td>
                <td><?=$status?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
   			</tr>
            <?
		}
	else{
			while($rowgetdata=mysqli_fetch_array($getdata))
			{
				$getempployeescked=mysqli_query($con,"select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and RFID='".$userid."'");
				while($employeesked=mysqli_fetch_array($getempployeescked)){
				if($employeesked[$day]=='1')
				{
					$status="Present";
					}
				else{
					$status="OT";
					}	
				}
				?>
                <tr <? if($status=='Present'){} else { echo 'bgcolor="yellowgreen" style="blue"';}?> >
                    <td><?=$day?></td>
                    <td><?=$x?></td>
                    <td><?=$status?></td>
                    <td><?=$rowgetdata['earlytimedate']?></td>
                    <td><?=$rowgetdata['startshift']?></td>
                    <td><?=$rowgetdata['endshift']?></td>
                    <td><?=$rowgetdata['otstart']?></td>
                    <td><?=$rowgetdata['otend']?></td>
               	</tr>
                <?	
			}
		
		}	
	?>

	<?
	}
?>
</table>
