<title>
 <?=$_POST['employeeid']?> - <?=$_POST['agentname']?> <?=$_POST['agenltname']?>'s Working Hours 
</title>
<?
include("db_connect.php");
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
?><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->

<!--
 .absent { background-color: red;  }
  .restday { background-color: #CCCCCC }
  .highlight { background-color: #8888FF }
//-->


</style>
<font color="#00CC00" size="+1"><?=$message?></font>
<form action="tlapprove.php" method="post">
<table border="1" cellpadding="2">
<tr bgcolor="#000000" style="color:#FFF">
				 <td>Date</td>
                <td>Reg H</td>
                <td>W/ ND</td>
                <td>Early</td>
                <td bgcolor="#00CC00" style="color:#000">A Early OT</td>
                <td>Late</td>
                <td>Undertime</td>
                <td>Regulat OT</td>
              <td bgcolor="#00CC00" style="color:#000">A RegOT</td>
                <td>OT w/ ND</td>
              <td bgcolor="#00CC00" style="color:#000">A OT w/ ND</td>
              <!--  <td>Shift</td>!-->
</tr>

<?
$month=$_POST['month'];
$payperiod=$_POST['payperiod'];
$year=$_POST['year']; 




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
	}
else{
	$startday=1;
	$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);
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
	$enddays=$days_in_month-$deducteddays;
	}	

	$starting=$year."-".$month."-".$startday;
	$ending=$year."-".$month."-".$enddays;
$gettimes="select timelog.*,prlemployeemaster.employeeid,prlemployeemaster.schedule from timelog,prlemployeemaster where prlemployeemaster.employeeid=timelog.userid and timelog.userid='".$_POST['employeeid']."' and timelog.dates>='".$starting."' and timelog.dates<='".$ending."' order by dates asc";
//echo $gettimes;
$gettimes=mysqli_query($con,$gettimes);
while($rowtimelogs=mysqli_fetch_array($gettimes)){
	$dates=$rowtimelogs['dates'];
	$userid=$rowtimelogs['userid'];
	$skedin=$rowtimelogs['skedin'];
	$skedout=$rowtimelogs['skedout'];
	$startshift=$rowtimelogs['startshift'];
	$endshift=$rowtimelogs['endshift'];
	$otherday=$rowtimelogs['otherday'];
	$datetomorrow = date('Y-m-d', strtotime($dates) + 86400);
	$dateyesterday = date('Y-m-d', strtotime($dates) - 86400);
if($rowtimelogs['status']=='Absent')
{
	$str_earlytime=0;
	$strtime_in=0;
	$strtime_out=0;
	$strsched_in=0;
	$strsched_out=0;
	$str_otstart=0;
	$str_otend=0;
	$totalworkinghours=0;
	$totalvalidhours=0;
	$total_time_before_nightdiff=0;
	$valid_time_before_nightdiff=0;
	$early_time_before_nightdiff=0;
	$late_hours=0;
	$total_time_after_nightdiff_end=0;
	$undertimehour=0;
	$total_ot_hours=0;
	$OT_with_night_diff=0;
	$ot_after_nightdiff=0;
	?>
    	<tr bgcolor="red"  onMouseOver="this.className='highlight'" onMouseOut="this.className='absent'">
            	<td><strong><?=$rowtimelogs['dates']?></strong></td>
            	<td>0</td>
                <td>0</td>
                <td>0</td>
                <td><input type="hidden" name="approveearly[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="0" />
                0</td>
                
                <td>0</td>
                <td>0</td>
               <td>0</td>
               <td><input type="hidden" name="approve[]" style="font-size:11px; background-color:#B0F9A6" size="8"  value="0" />0</td>
               <td>0</td>
                <td><input type="hidden" name="approvewithnd[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="0" />0</td>
               <!--  <td><?=$rowtimelogs['thisdaysshift']?></td><!-->
                
            </tr>
    <?
	$checkifavailable=mysqli_query($con,"select * from hourstable where shiftdate='".$dates."' and userid='".$userid."'");
	$numcountavail=mysqli_num_rows($checkifavailable);
	if($numcountavail<=0){
		//echo "insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours,status) values('".$dates."','".$dates."','".$userid."','".$early."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','0','0','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."')<br>";
		mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours,status) values('".$dates."','".$dates."','".$userid."','".$early."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','0','0','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours,status,late) values('".$dates."','".$datetomorrow."','".$userid."','0','".$tomwithoutnightdiff."','".$tomnightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."','0')" );
		}
	else{
		mysqli_query($con,"update hourstable set
		dates='".$dates."',
		early='".$early."',
		regular_hours='".$todayworkinghourswithoutnightdiff."',
		nightdiff_hours='".$todaynightdiffhours."',
		regular_ot_hours='0',
		nightdiff_ot_hours='0',
		late='".$late_hours."',
		undertime='".$undertimehour."',
		sixth_ot_hours='".$sixthday."',
		seventh_ot_hours='".$seventhday."',
		status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$dates."'");
		
		mysqli_query($con,"update hourstable set
		dates='".$datetomorrow."',
		early='0',
		regular_hours='".$tomwithoutnightdiff."',
		nightdiff_hours='".$tomnightdiffhours."',
		regular_ot_hours='".$Regulat_OT."',
		nightdiff_ot_hours='".$OT_with_night_diff."',
		late='0',
		undertime='".$undertimehour."',
		sixth_ot_hours='".$sixthday."',
		seventh_ot_hours='".$seventhday."',
		status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$datetomorrow."'");
		}
	}
else if($rowtimelogs['status']=='Restday'){
	$str_earlytime=0;
	$strtime_in=0;
	$strtime_out=0;
	$strsched_in=0;
	$strsched_out=0;
	$str_otstart=0;
	$str_otend=0;
	$totalworkinghours=0;
	$totalvalidhours=0;
	$total_time_before_nightdiff=0;
	$valid_time_before_nightdiff=0;
	$early_time_before_nightdiff=0;
	$late_hours=0;
	$total_time_after_nightdiff_end=0;
	$undertimehour=0;
	$total_ot_hours=0;
	$OT_with_night_diff=0;
	$ot_after_nightdiff=0;
	?>
    	<tr bgcolor="#CCCCCC" onMouseOver="this.className='highlight'" onMouseOut="this.className='restday'">
            	<td><strong><?=$rowtimelogs['dates']?></strong></td>
            	<td>0</td>
                <td>0</td>
                <td>0</td>
                <td><input type="hidden" name="approveearly[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="0" />0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td><input type="hidden" name="approve[]" style="font-size:11px; background-color:#B0F9A6" size="8"  value="0" />0</td>
                <td>0</td>
                <td><input type="hidden" name="approvewithnd[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="0" />0</td>
                <!--<td><?=$rowtimelogs['thisdaysshift']?></td>!-->
            </tr>
    <?
	
		$checkifavailable=mysqli_query($con,"select * from hourstable where shiftdate='".$dates."' and userid='".$userid."'");
		$numcountavail=mysqli_num_rows($checkifavailable);
		if($numcountavail<=0){
			mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours,status) values('".$dates."','".$dates."','".$userid."','".$early."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','0','0','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."')");
		mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours,status) values('".$dates."','".$datetomorrow."','".$userid."','0','".$tomwithoutnightdiff."','".$tomnightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."')" );
			}
		else{
			mysqli_query($con,"update hourstable set
			dates='".$dates."',
			early='".$early."',
			regular_hours='".$todayworkinghourswithoutnightdiff."',
			nightdiff_hours='".$todaynightdiffhours."',
			regular_ot_hours='0',
			nightdiff_ot_hours='0',
			late='".$late_hours."',
			undertime='".$undertimehour."',
			sixth_ot_hours='".$sixthday."',
			seventh_ot_hours='".$seventhday."',
			status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$dates."'");
			
			mysqli_query($con,"update hourstable set
			dates='".$datetomorrow."',
			early='0',
			regular_hours='".$tomwithoutnightdiff."',
			nightdiff_hours='".$tomnightdiffhours."',
			regular_ot_hours='".$Regulat_OT."',
			nightdiff_ot_hours='".$OT_with_night_diff."',
			late='".$late_hours."',
			undertime='".$undertimehour."',
			sixth_ot_hours='".$sixthday."',
			seventh_ot_hours='".$seventhday."',
			status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$datetomorrow."'");
			}
		}
else
{
	
	
	//$skedinarray=explode(' ', $skedin);
	//$skedoutarray=explode(' ', $skedout);
	
	/*$startshiftarray=explode(' ', $startshift);
	$endshiftarray=explode(' ', $endshift);
	
	//echo "<tr><td>select * from groupschedule where groupschedulename='".$rowtimelogs['thisdaysshift']."' limit 1</td></tr>";
	$getsked=mysqli_query($con,"select * from groupschedule where groupschedulename='".$rowtimelogs['thisdaysshift']."' limit 1");
	while($rowsked=mysqli_fetch_array($getsked)){
		$startshift=$startshiftarray[0]." ".$rowsked['starttime'];
		$endshift=$endshiftarray[0]." ".$rowsked['endtime'];
		}*/
	$earlytime=$rowtimelogs['earlytimedate'];
	
	$otstart=$rowtimelogs['otstart'];
	$otend=$rowtimelogs['otend'];
	
	$datetomorrow = date('Y-m-d', strtotime($dates) + 86400);
	$dateyesterday = date('Y-m-d', strtotime($dates) - 86400);
	
	$str_earlytime=0;
	$strtime_in=0;
	$strtime_out=0;
	$strsched_in=0;
	$strsched_out=0;
	$str_otstart=0;
	$str_otend=0;
	
	$str_earlytime=strtotime($earlytime);
	$strtime_in=strtotime($startshift);
	$strtime_out=strtotime($endshift);
	$strsched_in=strtotime($skedin);
	$strsched_out=strtotime($skedout);
	$str_otstart=strtotime($otstart);
	$str_otend=strtotime($rowtimelogs['otend']);
	
	
//	echo $otend ." = ".$str_otend;
	
	//12 midnight
	$midnighttime=$datetomorrow." 00:00:00";
	$strmidnighttime=strtotime($midnighttime);
	
	//$todaymidnight=$dates." 00:00:00";
	//$strtodaymidnight=strtotime($todaymidnight);
//	$todaynightdiffend=$dates." 06:00:00";
	//$strtodaynightdiffend=strtotime($todaynightdiffend);
	
	$todaymidnight=$datetomorrow." 00:00:00";
	$strtodaymidnight=strtotime($todaymidnight);
	$todaynightdiffend=$datetomorrow." 06:00:00";
	$strtodaynightdiffend=strtotime($todaynightdiffend);
	
	//if aftermidnightshift
	$todaymidnight12=$dates." 00:00:00";
	$strtodaymidnight12=strtotime($todaymidnight12);
	$todaynightdiffend12=$dates." 06:00:00";
	$strtodaynightdiffend12=strtotime($todaynightdiffend12);
	//echo $todaymidnight12."<br>";
	if($strtime_in>=$strtodaymidnight12&&strtodaynightdiffend12>=$strtime_in)
	{
		$todaymidnight=$dates." 00:00:00";
	$strtodaymidnight=strtotime($todaymidnight);
	$todaynightdiffend=$dates." 06:00:00";
	$strtodaynightdiffend=strtotime($todaynightdiffend);
	//echo $dates." - within the shift 12<br>";
	}
	
	if($strtodaymidnight<=$strtime_in && $strtodaynightdiffend>=$strtime_in){
	//echo $dates-"within the shift<br>";
		$nightdiff_start=$dateyesterday." 22:00:00";
		$nightdiff_out=$dates." 06:00:00";
		$strnightdiff_in=strtotime($nightdiff_start);
		$strnightdiff_out=strtotime($nightdiff_out);
	//echo $nightdiff_start;
	}
	
	else{
	//	echo $dates." - within the shift of today daw<br>";
		$nightdiff_start=$dates." 22:00:00";
		$nightdiff_out=$datetomorrow." 06:00:00";
		$strnightdiff_in=strtotime($nightdiff_start);
		$strnightdiff_out=strtotime($nightdiff_out);
		}	
	
		
$totalworkinghours=0;
$totalvalidhours=0;
$total_time_before_nightdiff=0;
$valid_time_before_nightdiff=0;
$early_time_before_nightdiff=0;
$late_hours=0;
$total_time_after_nightdiff_end=0;
$undertimehour=0;
$total_ot_hours=0;
$OT_with_night_diff=0;
$ot_after_nightdiff=0;
$early=0;
	//calculate early time
		if($earlytime!='0000-00-00 00:00:00' || $strearlytime<$str_earlytime)
		{
			$early=($strtime_in-$str_earlytime)/3600;
		}
		
		
	//check OT
if($strtime_out<$strsched_out)
				{
					 
					$undertimehour=($strsched_out-$strtime_out)/3600;
					//echo $strsched_out." ".$skedout." < ".$strtime_out." ".$endshift."<br>";
					$total_ot_hours=0;
					$Regulat_OT=0;
					$endworkingtime=$strtime_out;
					}
				else{
					echo $dates ."-here <br>";
					if($strnightdiff_out<=$str_otend){
						if($strsched_out>$strnightdiff_out){
							$ot_after_nightdiff=($str_otend-$str_otstart)/3600;
							}
						else{
							$ot_after_nightdiff=($str_otend-$strnightdiff_out)/3600;
							}
					
					//echo "wow<br>";
					}
					else{
						$ot_after_nightdiff=0;
						}
					$undertimehour=0;
					$total_ot_hours=($str_otend-$str_otstart)/3600;
					$endworkingtime=$strsched_out;
					
					//check if night diff start is greater than sched out that means ot with night diff
					if($strnightdiff_in>$strtime_out){
						//echo "<b>".$nightdiff_start."</b>";
					//echo $strnightdiff_in." - ".$strtime_out;
					//		echo "waaaaaaaaaa";
					if($strmidnighttime<$strtime_out){
							$OT_with_night_diff=($str_otend-$strnightdiff_in)/3600;
							if($OT_with_night_diff<0){
								$OT_with_night_diff=0;
								}
							$Regulat_OT=($total_ot_hours-$OT_with_night_diff);
							}
						}
						
					else{
						//echo $strnightdiff_in." - ".$strtime_out;
						$OT_with_night_diff=$total_ot_hours-$ot_after_nightdiff;
						$Regulat_OT=$ot_after_nightdiff;
						}	
						
					}
//calculate shift	
//check if out is less than out
if($strtime_out<$strtime_in)
{
	echo "<b><font color='#FF0000'>".$dates." - Error: Time in is greater than time out.(Please check the schedule for this date.)</font><b><br>";
	}
	
else{

				//check if late
				
					if($strtime_in>$strsched_in){
						$late_hours=($strtime_in-$strsched_in)/3600;
						$early_hours=0;
						$startworkingtime=$strtime_in;
						
						//get time before nightdiff
						}
					else{
						$late_hours=0;
						$early_hours=0;
						//check if timein is nightdiff
						$early_hours=($strsched_in-$strtime_in)/3600;
						$startworkingtime=$strsched_in;
						//get time before nightdiff
			
				//$valid_time_before_nightdiff=($strnightdiff_in-$startworkingtime)/3600;
				//		$early_time_before_nightdiff=$total_time_before_nightdiff-$valid_time_before_nightdiff;
						}
						if($startworkingtime<$strnightdiff_in){
							
						$valid_time_before_nightdiff=($strnightdiff_in-$startworkingtime)/3600;
						$early_time_before_nightdiff=$total_time_before_nightdiff-$valid_time_before_nightdiff;
						}
						else{
							
							$strnightdiff_in=$strtime_in;
							$early_time_before_nightdiff=0;
							
							}
						

//if time out is greater than midnight
			if($strmidnighttime<$strtime_out){
				
			$todaytimein=$strtime_in;
			$todaytimeout=$strmidnighttime;
			$tomtimein=$strmidnighttime;
			$tomtimeout=$endworkingtime;
		
				//calculate time before midnight
				
				if($strtodaymidnight<$strtime_in ){
						//echo $todaymidnight."<br>";
						//echo $dates." - here - ".$todaymidnight."<br>";
						$todayworkinghourswithoutnightdiff=0;
						$todaynightdiffhours=0;
						$tomtimein=$strtime_in;
					}
				else{
					//echo $dates."=".$todaymidnight."=".$early_time_before_nightdiff."<br>";
					$todayworkinghourswithoutnightdiff=$valid_time_before_nightdiff;
					$todaynightdiffhours=($todaytimeout-$strnightdiff_in)/3600;
					}	
				
				
				if($endworkingtime>$strnightdiff_out){
					//echo "<br>".$nightdiff_out;
					//echo $dates;
				$tomwithoutnightdiff=($endworkingtime-$strnightdiff_out)/3600;
				$tomnightdiffhours=($strnightdiff_out-$tomtimein)/3600;
				
				}
				else{
					//echo $dates;
					$tomwithoutnightdiff=0;
					$tomnightdiffhours=($tomtimeout-$tomtimein)/3600;
					}
				
			}
			
			else{
				
				//echo $dates." - ";
				$Regulat_OT=0;
				$todayworkinghourswithoutnightdiff=0;
				$Regulat_OT=($str_otend-$str_otstart )/3600;
				//echo $Regulat_OT;
				$tomnightdiffhours=0;
				if($strtodaymidnight<$strtime_in && $strtodaynightdiffend>$strtime_in){
					//echo $dates."-naa today <br>";
					//echo $endworkingtime." > ".$strnightdiff_out."<br>";
					if($endworkingtime>$strnightdiff_out){
				
					$todayworkinghourswithoutnightdiff=($endworkingtime-$strnightdiff_out)/3600;
					$todaynightdiffhours=($strnightdiff_out-$startworkingtime)/3600;
					//echo $dates." - ".$todaynightdiffhours."<br>";
					//echo $dates."-naa today <br>";
					}
					else{
						//echo "wala today";
						$todayworkinghourswithoutnightdiff=0;
						$todaynightdiffhours=($endworkingtime-$startworkingtime)/3600;
						}
				}
				else{
					//echo "here<br>";
					//echo $dates."-naa today <br>";
					$todayworkinghourswithoutnightdiff=(($endworkingtime-$startworkingtime)/3600);
//echo $todayworkinghourswithoutnightdiff;
					$todaynightdiffhours=0;
							if($endworkingtime>$strnightdiff_out){
								
							//echo "<br>".$nightdiff_out;
							//echo $dates."<br>";
						$tomwithoutnightdiff=($endworkingtime-$strnightdiff_out)/3600;
						$tomnightdiffhours=($strnightdiff_out-$tomtimein)/3600;
						
						}
						else{
							//echo $dates."-".$nightdiff_start."<br>";
						
							//echo $dates."<br>";
							$tomwithoutnightdiff=0;
							$tomnightdiffhours=($tomtimeout-$tomtimein)/3600;
							//echo $dates." - ".$todaymidnight." - ".$endshift." - ".$startshift."<br>";
								if($strtodaymidnight<$strtime_in && $strtodaynightdiffend>$strtime_in ){
									//	echo $todaymidnight."<br>";
									//echo $strsched_out."-".$strnightdiff_in."<br>";
									$todayworkinghourswithoutnightdiff=$valid_time_before_nightdiff;
									$todaynightdiffhours=($strsched_out-$strnightdiff_in)/3600;
										
									}
								else{
									$todaynightdiffhours=0;
										$tomnightdiffhours=0;
									}	
								
							}
					}
				
			}
			//echo "-".$todaynightdiffhours."-".$tomwithoutnightdiff;
			
			if($OT_with_night_diff<0){
		$OT_with_night_diff=0;
		}
	if($tomwithoutnightdiff<0){
		$tomwithoutnightdiff=0;
	}
	if($todaynightdiffhours<0){
		$tomnightdiffhours=0;
	}
	if($todaynightdiffhours<0){
		$tomnightdiffhours=0;
	}
	if($early>10 || $early=='' || $early<=0){
		$early=0;
	}
			?>
			<tr <? if($rowtimelogs['status']=='Vacation Leave'){ echo "bgcolor='yellowgreen'";}?>  onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
            	<td><strong><?=$dates?></strong></td>
            	<td>
					<?
					//echo $todayworkinghourswithoutnightdiff."-";
                		$reghours=$todayworkinghourswithoutnightdiff+$tomwithoutnightdiff;
						echo round($reghours,2);
					?>
                </td>
                <td><?
				//echo $todaynightdiffhours."+".$tomnightdiffhours."-".$late_hours;
                		$hourswithnightdiff=$todaynightdiffhours+$tomnightdiffhours;
						if($late_hours>=4)
						{
							$hourswithnightdiff=$hourswithnightdiff+1;
							}
							echo $todaynightdiffhours."+".$tomnightdiffhours."<br>";
						echo round($hourswithnightdiff,2);
					?></td>
                <td><?=round($early,2)?></td>
                <td>
                <?
				if($approve=='1')
				{
				//	echo "SELECT early,regular_ot_hours,nightdiff_ot_hours FROM `finalhourstable` where shiftdate='".$dates."' and userid='".$userid."' <br>";
					$finalhourstable2=mysqli_query($con,"SELECT early,regular_ot_hours,nightdiff_ot_hours
FROM `finalhourstable` where shiftdate='".$dates."' and userid='".$userid."'");
					
					$earlyz=0;
					$regular_ot_hoursz=0;
					$nightdiff_ot_hoursz=0;
					while($rowfinalhourstable=mysqli_fetch_array($finalhourstable2)){
						$earlyz=$earlyz+$rowfinalhourstable['early'];
						$regular_ot_hoursz=$regular_ot_hoursz+$rowfinalhourstable['regular_ot_hours'];
						$nightdiff_ot_hoursz=$nightdiff_ot_hoursz+$rowfinalhourstable['nightdiff_ot_hours'];
						}
					

 	
 	
}
				?>
                <input type="text" name="approveearly[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="<?=$earlyz?>" /></td>
              <td <? if($late_hours>0){ echo 'bgcolor="red"';} ?>><?=round($late_hours,2)?></td>
                <td <? if($undertimehour>0){ echo "bgcolor='orange'";} ?>><? 
				
				if($undertimehour>23)
				{
					$undertimehour=0;
					}
				echo round($undertimehour,2);
				
				?></td>
              <td><?=round($Regulat_OT,2)?></td>
                <td ><input type="text" name="approve[]" style="font-size:11px; background-color:#B0F9A6" size="8"  value="<?=$regular_ot_hoursz?>" /></td>
      <td><?=round($OT_with_night_diff,2)?></td>
                <td><input type="text" name="approvewithnd[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="<?=$nightdiff_ot_hoursz?>" /></td>
             
            <!--  <td><?=$rowtimelogs['thisdaysshift']?></td>
                <td><?=strtotime($skedin)?></td>
                <td><?=strtotime($rowtimelogs['startshift'])?></td>
                <td><?=$skedout?></td>
                <td><?=$rowtimelogs['endshift']?></td>
                <td><?=$strtime_in?></td><td><?=$strsched_in?></td>!-->
            </tr>
           
            <?
			if($rowtimelogs['status']=='6th day OT')
			{
				$sixthday=1;
			}
			else{
				$sixthday=0;
				}
			if($rowtimelogs['status']=='7th day OT')
			{
				$seventhday=1;
			}
			else{
				$seventhday=0;
				}	
			$tomnightdiffhours=$tomnightdiffhours-$late_hours;
				if($late_hours>=4)
						{
							$tomnightdiffhours=$tomnightdiffhours+1;
							}
}
	$checkifavailable=mysqli_query($con,"select * from hourstable where shiftdate='".$dates."' and userid='".$userid."'");
	$numcountavail=mysqli_num_rows($checkifavailable);
	if($numcountavail<=0){
		mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours,status) values('".$dates."','".$dates."','".$userid."','".$early."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','0','0','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours,status) values('".$dates."','".$datetomorrow."','".$userid."','0','".$tomwithoutnightdiff."','".$tomnightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$sixthday."','".$seventhday."','".$rowtimelogs['status']."')" );
		}
	else{
		mysqli_query($con,"update hourstable set
		dates='".$dates."',
		early='".$early."',
		regular_hours='".$todayworkinghourswithoutnightdiff."',
		nightdiff_hours='".$todaynightdiffhours."',
		regular_ot_hours='0',
		nightdiff_ot_hours='0',
		late='".$late_hours."',
		undertime='".$undertimehour."',
		sixth_ot_hours='".$sixthday."',
		seventh_ot_hours='".$seventhday."',
		status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$dates."'");
		
		/*
		orig
		mysqli_query($con,"update hourstable set
		dates='".$datetomorrow."',
		early='0',
		regular_hours='".$tomwithoutnightdiff."',
		nightdiff_hours='".$tomnightdiffhours."',
		regular_ot_hours='".$Regulat_OT."',
		nightdiff_ot_hours='".$OT_with_night_diff."',
		late='".$late_hours."',
		undertime='".$undertimehour."',
		sixth_ot_hours='".$sixthday."',
		seventh_ot_hours='".$seventhday."',
		status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$datetomorrow."'");
		*/
		mysqli_query($con,"update hourstable set
		dates='".$datetomorrow."',
		early='0',
		regular_hours='".$tomwithoutnightdiff."',
		nightdiff_hours='".$tomnightdiffhours."',
		regular_ot_hours='".$Regulat_OT."',
		nightdiff_ot_hours='".$OT_with_night_diff."',
		late='0',
		undertime='0',
		sixth_ot_hours='0',
		seventh_ot_hours='0',
		status='".$rowtimelogs['status']."' where userid='".$userid."' and  shiftdate='".$dates."' and dates='".$datetomorrow."'");
		}
	}
	?>
    <input type="hidden" name="dates[]" value="<?=$dates?>" />
    <?
}
?>
<tr><td colspan="11" align="right">
<input type="hidden" value="<?=$_POST['employeeid']?>" name="employeeid" />
<input type="hidden" value="<?=$_POST['agentname']?>" name="agentname" />
<input type="hidden" value="<?=$_POST['agenltname']?>" name="agenltname" />
  
<input type="hidden" value="<?=$pyear?>-<?=$pmonth?>-<?=$ppayperiod?>" name="payperiod" />

  
<input type="submit" name="submit" value="Approve" <? if($approve=='1'){ echo'disabled="disabled"';} ?> onclick="return confirm('Are you Sure?');" />
</td></tr>
</table>
</form>