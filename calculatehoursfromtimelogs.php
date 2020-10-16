<?
include("db_connect.php");

$gettimes=mysqli_query($con,"select timelog.*,prlemployeemaster.employeeid from timelog,prlemployeemaster where prlemployeemaster.employeeid=timelog.userid");
while($rowtimelogs=mysqli_fetch_array($gettimes)){
if($rowtimelogs['status']=='Absent')
{}
else if($rowtimelogs['status']=='Restday'){}
else
{
	$dates=$rowtimelogs['dates'];
	$userid=$rowtimelogs['userid'];
	$skedin=$rowtimelogs['skedin'];
	$skedout=$rowtimelogs['skedout'];
	$earlytime=$rowtimelogs['earlytimedate'];
	$startshift=$rowtimelogs['startshift'];
	$endshift=$rowtimelogs['endshift'];
	$otstart=$rowtimelogs['otstart'];
	$otend=$rowtimelogs['otend'];
	
	$datetomorrow = date('Y-m-d', strtotime($dates) + 86400);
	$dateyesterday = date('Y-m-d', strtotime($dates) - 86400);
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
							$OT_with_night_diff=($str_otend-$strnightdiff_in)/3600;
							if($OT_with_night_diff<0){
								$OT_with_night_diff=0;
								}
							$Regulat_OT=($total_ot_hours-$OT_with_night_diff);
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
			?>
			
            <table>
            <tr>
                <td></td>
                <td><strong><?=$dates?></strong></td>
            </tr>
            <tr>
                <td>todayworkinghourswithoutnightdiff:</td>
                <td><?=$todayworkinghourswithoutnightdiff?></td>
            </tr>
            <tr>
                <td>todaynightdiffhours:</td>
                <td><?=$todaynightdiffhours?></td>
            </tr>
            <tr>
                <td>tomnightdiffhours:</td>
                <td><?=$tomnightdiffhours?></td>
            </tr>
            <tr>
                <td>tomwithoutnightdiff:</td>
                <td><?=$tomwithoutnightdiff?></td>
            </tr>
            <!--  echo $strtime_in."-".$str_earlytime."=". !-->
             <tr>
                <td>early:</td>
                <td><?=$early?></td>
            </tr>
            <tr>
                <td>late:</td>
                <td><?=$late_hours?></td>
            </tr>
             <tr>
                <td>undertimehour:</td>
                <td><?=$undertimehour?></td>
            </tr>
            <tr>
                <td>Regulat_OT:</td>
                <td><?=$Regulat_OT?></td>
            </tr>
           <!--  echo "otend:".$str_otend." - ".$str_otstart." = ". !-->
            <tr>
                <td>OT_with_night_diff:</td>
                <td><?=$OT_with_night_diff?></td>
            </tr>
            
            </table>
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

}
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
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$dates."','".$userid."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$datetomorrow."','".$userid."','".$tomwithoutnightdiff."','".$tomnightdiffhours."','0','0','".$sixthday."','".$seventhday."')" );
	}
}
?>