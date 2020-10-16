<?php
include("db_connect.php");
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
<form action="transferhours.php" method="post">
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

<?php
//$employeeid=$_POST['employeeid'];
$employeeid="0900014";
$gettimes=mysqli_query($con,"select timelog.*,prlemployeemaster.employeeid,prlemployeemaster.schedule from timelog,prlemployeemaster where prlemployeemaster.employeeid=timelog.userid and timelog.userid='".$_POST['employeeid']."'");
while($rowtimelogs=mysqli_fetch_array($gettimes)){
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
            	<td><strong><?php echo $rowtimelogs['dates']?></strong></td>
            	<td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                
                <td>0</td>
                <td>0</td>
               <td>0</td>
               <td>0</td>
               <td>0</td>
                <td>0</td>
               <!--  <td><?php echo $rowtimelogs['thisdaysshift']?></td><!-->
                
            </tr>
    <?php
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
            	<td><strong><?php echo $rowtimelogs['dates']?></strong></td>
            	<td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <!--<td><?php echo $rowtimelogs['thisdaysshift']?></td>!-->
            </tr>
    <?php
	}
else
{
	$dates=$rowtimelogs['dates'];
	$userid=$rowtimelogs['userid'];
	$skedin=$rowtimelogs['skedin'];
	$skedout=$rowtimelogs['skedout'];
	$startshift=$rowtimelogs['startshift'];
	$endshift=$rowtimelogs['endshift'];
	
	//$skedinarray=explode(' ', $skedin);
	//$skedoutarray=explode(' ', $skedout);
	
	$startshiftarray=explode(' ', $startshift);
	$endshiftarray=explode(' ', $endshift);
	
	//echo "<tr><td>select * from groupschedule where groupschedulename='".$rowtimelogs['thisdaysshift']."' limit 1</td></tr>";
	$getsked=mysqli_query($con,"select * from groupschedule where groupschedulename='".$rowtimelogs['thisdaysshift']."' limit 1");
	while($rowsked=mysqli_fetch_array($getsked)){
		$startshift=$startshiftarray[0]." ".$rowsked['starttime'];
		$endshift=$endshiftarray[0]." ".$rowsked['endtime'];
		}
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
	
	if($strtodaymidnight<=$strtime_in && $strtodaynightdiffend>=$strtime_in){
	//echo "within the shift";
	$nightdiff_start=$dateyesterday." 22:00:00";
	$nightdiff_out=$datetomorrow." 06:00:00";
	$strnightdiff_in=strtotime($nightdiff_start);
	$strnightdiff_out=strtotime($nightdiff_out);
	//echo $nightdiff_start;
	}
	
	else{
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

	//calculate early time
		if($earlytime!='0000-00-00 00:00:00' || $strearlytime<$str_earlytime)
		{
			$early=($strtime_in-$str_earlytime)/3600;
		}
		
	//check OT
if($strtime_out<$strsched_out)
				{
					$undertimehour=($strsched_out-$strtime_out)/3600;
					$total_ot_hours=0;
					$Regulat_OT=0;
					$endworkingtime=$strtime_out;
					}
				else{
					if($strnightdiff_out<=$str_otend){
						if($strsched_out>$strnightdiff_out){
							$ot_after_nightdiff=($str_otend-$strsched_out)/3600;
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
					$total_ot_hours=($str_otend-$strsched_out)/3600;
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
	echo "Error: Time in is greater than time out.";
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
						//echo $todaymidnight;
						
						$todayworkinghourswithoutnightdiff=0;
						$todaynightdiffhours=0;
					}
				else{
					$todayworkinghourswithoutnightdiff=$valid_time_before_nightdiff;
					$todaynightdiffhours=($todaytimeout-$strnightdiff_in)/3600;
					}	
				
				
				if($endworkingtime>$strnightdiff_out){
					//echo "<br>".$nightdiff_out;
				$tomwithoutnightdiff=($endworkingtime-$strnightdiff_out)/3600;
				$tomnightdiffhours=($strnightdiff_out-$tomtimein)/3600;
				
				}
				else{
					$tomwithoutnightdiff=0;
					$tomnightdiffhours=($tomtimeout-$tomtimein)/3600;
					}
				
			}
			
			else{
				
				if($strtodaymidnight<$strtime_in && $strtodaynightdiffend>$strtime_in){
					if($endworkingtime>$strnightdiff_out){
					$todayworkinghourswithoutnightdiff=($endworkingtime-$strnightdiff_out)/3600;
					$todaynightdiffhours=($strnightdiff_out-$startworkingtime)/3600;
					}
					else{
						$todayworkinghourswithoutnightdiff=0;
						$todaynightdiffhours=($endworkingtime-$startworkingtime)/3600;
						}
				}
				else{
					$todayworkinghourswithoutnightdiff=(($endworkingtime-$startworkingtime)/3600);
					
					}
				
			}
			//echo $todaynightdiffhours;
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
	if($early>10 || $early==''){
		$early=0;
	}
			?>
			<tr  onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
            	<td><strong><?php echo $dates?></strong></td>
            	<td>
					<?php
                		$reghours=$todayworkinghourswithoutnightdiff+$tomwithoutnightdiff;
						echo round($reghours,2);
					?>
                </td>
                <td>
                	<?php
                		$hourswithnightdiff=$todaynightdiffhours+$tomnightdiffhours;
						echo round($hourswithnightdiff,2);
					?>
                </td>
                <td><?php echo round($early,2)?></td>
                <td><input type="text" name="approveearly[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="0" /></td>
              <td><?php echo round($late_hours,2)?></td>
                <td><?php echo round($undertimehour,2)?></td>
              <td><?php echo round($Regulat_OT,2)?></td>
                <td ><input type="text" name="approve[]" style="font-size:11px; background-color:#B0F9A6" size="8" value="0" /></td>
      <td><?php echo round($OT_with_night_diff,2)?></td>
                <td><input type="text" name="approvewithnd[]" style="font-size:11px; background-color:#B0F9A6" size="8"  value="0" /></td>
             <input type="hidden" name="dates[]" value="<?php echo $dates?>" />
               <!-- <td><?php echo $rowtimelogs['thisdaysshift']?></td>
                <td><?php echo $skedin?></td>
                <td><?php echo $rowtimelogs['timein']?></td>
                
                 	
                <td><?php echo $skedout?></td>
                <td><?php echo $rowtimelogs['timeout']?></td>!-->
            </tr>
           
            <?php
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

}
	$checkifavailable=mysqli_query($con,"select * from hourstable where shiftdate='".$dates."' and userid='".$userid."'");
	$numcountavail=mysqli_num_rows($checkifavailable);
	if($numcountavail<=0){
		mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$dates."','".$userid."','".$early."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','0','0','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$datetomorrow."','".$userid."','0','".$tomwithoutnightdiff."','".$tomnightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$sixthday."','".$seventhday."')" );
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
		seventh_ot_hours='".$seventhday."' where userid='".$userid."' and  shiftdate='".$dates."'");
		
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
		seventh_ot_hours='".$seventhday."' where userid='".$userid."' and  shiftdate='".$dates."'");
		}
	}
}
?>
<tr><td colspan="11" align="right">
<input type="hidden" value="<?php echo $_POST['employeeid']?>" name="employeeid" />
<input type="submit" name="submit" value="Approve" />
</td></tr>
</table>
</form>