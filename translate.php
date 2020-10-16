<table border="1">
<tr>
	<td>userid</td>
    <td>firstname</td>
    <td>middlename</td>
    <td>lastname</td>
	<td>shiftdate</td>
    <td>timein</td>
    <td>timeout</td>
    <td>status</td>
    <td>schedule</td>
    <td>starttime</td>
    <td>endtime</td>
    <td>otherday</td>
</tr>
<?
include("db_connect.php");
$month=11;
$startday=1;//16
$year=2010;
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
		

$getdata=mysqli_query($con,"select uploaded.*,prlemployeemaster.* from uploaded,prlemployeemaster where prlemployeemaster.employeeid=uploaded.userid group by uploaded.userid  order by uploaded.userid asc");
$numcount=mysqli_num_rows($getdata);
while($rowdata=mysqli_fetch_array($getdata)){
	/*$getempployeescked="select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and employeeid='".$rowdata['userid']."'";
	$sked=mysqli_query($con,$getempployeescked);
	
	while($rowsked=mysqli_fetch_array($sked)){
		$otherday=$rowsked['otherday'];
		$starttime=$rowsked['starttime']; 	 	
		$endtime=$rowsked['endtime'];
		
		}
	
	 	//echo date("Y-m-d")." ".$rowdata['timein']."  --> ".date("Y-m-d")." ".$rowdata['timeout']."<br>";
			//	$checktimein=strtotime($rowdata['timein']);
				//$checktimeout=strtotime($rowdata['timeout']);
				//echo $checktimein." - ".$checktimeout."<br>";
				
				//echo $rowdata['shiftdate'] ." ---> ". date("Y-m-d", strtotime($rowdata['shiftdate']) + 86400)."<br>";
				
				
				?>
    <tr>
        <td><?=$rowdata['userid']?></td>
        <td><?=$rowdata['firstname']?></td>
        <td><?=$rowdata['middlename']?></td>
        <td><?=$rowdata['lastname']?></td>
        <td><?=$rowdata['shiftdate']?></td>
        <td><?=$timein?></td>
        <td><?=$timeout?></td>
        <td><?=$rowdata['status']?></td>
        <td><?=$rowdata['schedule']?></td>
        <td><?=$starttime?></td>
        <td><?=$endtime?></td>
        <td><?=$otherday?></td>
        
	</tr>
    <?
	
	if($otherday=='1')
				{
					$shiftdateend = date("Y-m-d", strtotime($rowdata['shiftdate']) + 86400);
					//echo $shiftdateend."<br>";
				}
				else{
					$shiftdateend = $rowdata['shiftdate'];
					}
									$timein=$rowdata['shiftdate']." ".$rowdata['timein'];
									$timeout=$shiftdateend." ".$rowdata['timeout'];
									$strtimein=strtotime($timein);
									$strtimeout=strtotime($timeout);
	
	*/
	
	$userid=$rowdata['userid'];
	
				
									
									
	
					for($y=$startday;$y<=$enddays;$y++){
						
						$getempployeescked="select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and prlemployeemaster.employeeid='".$rowdata['userid']."'";
				//echo $getempployeescked."<br>";
				$getempployeescked=mysqli_query($con,$getempployeescked);
				while($employeesked=mysqli_fetch_array($getempployeescked)){
									
							$groupschedulename=$employeesked['groupschedulename']; 		
							$starttime=$employeesked['starttime']; 	
							$endtime=$employeesked['endtime'];
							$otherday=$employeesked['otherday'];			
							$Mon=$employeesked['Mon'];
							$Tue=$employeesked['Tue'];
							$Wed=$employeesked['Wed'];
							$Thu=$employeesked['Thu'];
							$Fri=$employeesked['Fri'];
							$Sat=$employeesked['Sat'];
							$Sun=$employeesked['Sun'];
								}
								
						$thisdate=$year."-".$month."-".$y;
					
					$getdata2="select uploaded.*,prlemployeemaster.* from uploaded,prlemployeemaster where prlemployeemaster.employeeid=uploaded.userid and uploaded.shiftdate='".$thisdate."' and prlemployeemaster.employeeid='".$rowdata['userid']."' order by uploaded.userid asc";
					echo $getdata2."<br>";
					$getdata2=mysqli_query($con,$getdata2);
					//$numcount=mysqli_num_rows($getdata);
					while($rowdata2=mysqli_fetch_array($getdata2)){
	$getstatus=$rowdata2['status'];
						if($otherday=='1')
						{
							$shiftdateend = date("Y-m-d", strtotime($rowdata2['shiftdate']) + 86400);
							//echo $shiftdateend."<br>";
						}
						else{
							$shiftdateend = $rowdata2['shiftdate'];
							}
											$timein=$rowdata2['shiftdate']." ".$rowdata2['timein'];
											$timeout=$shiftdateend." ".$rowdata2['timeout'];
											$strtimein=strtotime($timein);
											$strtimeout=strtotime($timeout);
						}
						
						
						
						echo $thisdate."<br>";
						$startskeddaw=$thisdate." ".$starttime;
						if($otherday=='1')
						{
							$tomday=$y+1;
							}
						else{
							$tomday=$y;
							}	
						$tomdatedate=$year."-".$month."-".$tomday;
						
						$endskeddaw=$tomdatedate." ".$endtime;
						$strstartskeddaw=strtotime($startskeddaw);
						$strendskeddaw=strtotime($endskeddaw);
						if($strtimein>=$strstartskeddaw && $strtimein<$strendskeddaw)
						{
							
						//	echo "today:".$thisdate." tomorow:".$tomdatedate."<br>";
							$startshiftdate=$thisdate;
							//check if early
							if($strtimein<$strstartskeddaw)
							{
								$early=$timein;
								$startshift=$startskeddaw;
								//$earlydatetime=date('H:i:s',$early);
							}
							else{
								$early="0000-00-00 00:00:00";
								$startshift=$timein;
								}
						//	echo "early:".$early." startshift:".$startshift."<br>";
							
							if($strtimeout>$strendskeddaw)
							{
								$endshift=$endskeddaw;
								$otstart=$endskeddaw;
								$otend=$timeout;
								}
							else{
								$endshift=$timeout;
								$otstart="0000-00-00 00:00:00";
								$otend="0000-00-00 00:00:00";
								}	
						//	echo "startsked = ".$startskeddaw."       endsked = ".$endskeddaw."   shiftdate:".$startshiftdate."<br>";
						//	echo "    Endshift:".$endshift."OTstart:".$otstart." otend:".$otend."<br>";	
						//	echo $strtimein." - ".$strstartskeddaw." - ".$strendskeddaw."<br>";
							
							$shiftday=date("D", $strstartskeddaw);
							switch($shiftday){
							case 'Mon':
										if($Mon=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											
											}	
									break;
							case 'Tue':
										if($Tue=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;
							case 'Wed':
										if($Wed=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											
											}	
									break;	
							case 'Thu':
										if($Thu=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											
											}	
									break;	
							case 'Fri':
										if($Fri=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											
											}	
									break;	
							case 'Sat':
										if($Sat=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											
											}	
									break;	
							case 'Sun':
										if($Sun=='1')
										{
											//$status="Present";
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
											}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											
											}	
									break;		
								
								}
								
								
								/*if($otherday=='1')
								{
									$shiftdateend = date("Y-m-d", strtotime($rowdata['shiftdate']) + 86400);
									//echo $shiftdateend."<br>";
								}
								else{
									$shiftdateend = $rowdata['shiftdate'];
									}
									
									//$startshift=$rowdata['shiftdate']." ".$starttime;
									//$endshift=$shiftdateend." ".$endtime;
								*/
								
							$querychecktimelog="select * from timelog where dates='".$startshiftdate."' and userid='".$userid."'";
							//echo $querychecktimelog;
							$querychecktimelog=mysqli_query($con,$querychecktimelog);
							if (mysqli_num_rows($querychecktimelog) == 0)
								{
								$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`,`thisdaysshift`)values('".$startshiftdate."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$early."','".$startshift."','".$endshift."','".$otstart."','".$otend."','".$groupschedulename."')";
								//echo $insert;
								mysqli_query($con,$insert);
								}
							else{
								mysqli_query($con,"update timelog set `status`='".$status."',`shiftday`='".$shiftday."',`skedin`='".$startskeddaw."',`skedout`='".$endskeddaw."',`timein`='".$timein."',`timeout`='".$timeout."',`earlytimedate`='".$early."',`startshift`='".$startshift."',`endshift`='".$endshift."',`otstart`='".$otstart."',`otend`='".$otend."',`thisdaysshift`='".$groupschedulename."' where dates='".$startshiftdate."' and userid='".$userid."'");
								}
							
						
						}
					
						if($strtimein<=$strstartskeddaw){
							//echo "dakoooooo   today:".$thisdate." tomorow:".$tomdatedate."<br>";
							$startshiftdate=$thisdate;
							
							//echo "today:".$thisdate." tomorow:".$tomdatedate."<br>";
							if($strtimein<$strstartskeddaw)
							{
								$endshift=$endskeddaw;
								$early=$timein;
								$startshift=$startshiftdate." ".$starttime;
								//$earlydatetime=date('H:i:s',$early);
							}
							else{
								$early="0000-00-00 00:00:00";
								$startshift=$timein;
								}
							//echo "early:".$early." startshift:".$startshift."<br>";
							if($strtimeout>$strendskeddaw)
							{
								$endshift=$endskeddaw;
								$otstart=$endskeddaw;
								$otend=$timeout;
								}
							else{
								$endshift=$timeout;
								$otstart="0000-00-00 00:00:00";
								$otend="0000-00-00 00:00:00";
								
								}	
							
						//	echo "startsked = ".$startskeddaw."       endsked = ".$endskeddaw."   shiftdate:".$startshiftdate."<br>";
						//	echo "OTstart:".$otstart." otend:".$otend."<br>";	
						//	echo $strtimein." - ".$strstartskeddaw." - ".$strendskeddaw."<br>";
							
							
							switch($shiftday){
							case 'Mon':
										if($Mon=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}	
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}	
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
										
									break;
							case 'Tue':
										if($Tue=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;
							case 'Wed':
										if($Wed=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;	
							case 'Thu':
										if($Thu=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;	
							case 'Fri':
										if($Fri=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;	
							case 'Sat':
										if($Sat=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;	
							case 'Sun':
										if($Sun=='1')
										{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												//$status="OT";
												$status="Present";
												}
											}
										else{
											if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}	
											}	
									break;	
								
								default:
								if($getstatus=='OFF'){
												$status="Restday";
												}
											else if($getstatus=='Absent'){
												$status="Absent";
												}
											else if($getstatus=='VL'){
												$status="Vacation Leave";
												}
											else if($getstatus=='SICK'){
												$status="Sick Leave";
											}
											else {
												$status="OT";
												//$status="Present";
												}
												break;
								
								}
								
							
									
							
							$querychecktimelog=mysqli_query($con,"select * from timelog where dates='".$startshiftdate."' and userid='".$userid."'");
							if (mysqli_num_rows($querychecktimelog) == 0)
								{
								$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`,`thisdaysshift`)values('".$startshiftdate."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$early."','".$startshift."','".$endshift."','".$otstart."','".$otend."','".$groupschedulename."')";
								//echo $insert;
								mysqli_query($con,$insert);
								}
							else{
								mysqli_query($con,"update timelog set `status`='".$status."',`shiftday`='".$shiftday."',`skedin`='".$startskeddaw."',`skedout`='".$endskeddaw."',`timein`='".$timein."',`timeout`='".$timeout."',`earlytimedate`='".$early."',`startshift`='".$startshift."',`endshift`='".$endshift."',`otstart`='".$otstart."',`otend`='".$otend."',`thisdaysshift`='".$groupschedulename."' where dates='".$startshiftdate."' and userid='".$userid."'");
								}
							
							
							
							
							}
						
					}
					
			
	}
?>
</table>

<?
/*
$month=10;
$year=2010;
$days_in_month=cal_days_in_month(CAL_GREGORIAN, $month, $year);

$getuserid=mysqli_query($con,"select userid from timelog group by userid");
while($getuserid=mysqli_fetch_array($getuserid)){
	$userid=$getuserid['userid'];
for($x=16;$x<=$days_in_month;$x++){

	$day=date('D',mktime(0, 0, 0, $month, $x, $year));
	
	$getdata2="select * from timelog where userid='".$userid."' and dates='".$year."-".$month."-".$x."' order by dates asc";
	echo $getdata2."<br>";
	$getdata=mysqli_query($con,$getdata2);
	
	if (mysqli_num_rows($getdata) == 0)
		{
			$getempployeescked="select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and employeeid='".$userid."'";
//			echo $getempployeescked."<br>";
			$getempployeescked=mysqli_query($con,$getempployeescked);
				while($employeesked=mysqli_fetch_array($getempployeescked)){
				if($employeesked[$day]=='1')
				{
					$status="Absent";
				}
				else{
					$status="Restday";
				}
			$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$year."-".$month."-".$x."','".$day."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";
					echo $insert."<br>";
					mysqli_query($con,$insert);
					//echo '<META HTTP-EQUIV="refresh" CONTENT="0; URL=calendar.php">'; 
					//exit();
				}
			
		
		}	
}
}


//$userid="1094";
//$gettimes=mysqli_query($con,"select * from timelog where userid='".$userid."' order by dates asc");
$gettimes=mysqli_query($con,"select * from timelog order by dates asc");
while($rowtimelogs=mysqli_fetch_array($gettimes)){
if($rowtimelogs['status']=='Absent')
{
	$todayworkinghourswithoutnightdiff=0;
	$todaynightdiffhours=0;
	$Regulat_OT=0;
	$OT_with_night_diff=0;
	$late_hours=0;
	$undertimehour=0;
	$sixthday=0;
	$seventhday=0;
	$tomwithoutnightdiff=0;
	$tomnightdiffhours=0;
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours)values('".$dates."','".$dates."','".$userid."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours)values('".$dates."','".$datetomorrow."','".$userid."','".$tomwithoutnightdiff."','".$tomnightdiffhours."','0','0','".$sixthday."','".$seventhday."')" );
	}
else if($rowtimelogs['status']=='Restday'){
	$todayworkinghourswithoutnightdiff=0;
	$Regulat_OT=0;
	$OT_with_night_diff=0;
	$late_hours=0;
	$undertimehour=0;
	$sixthday=0;
	$seventhday=0;
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$dates."','".$userid."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$datetomorrow."','".$userid."','".$tomwithoutnightdiff."','".$tomnightdiffhours."','0','0','".$sixthday."','".$seventhday."')" );
	}
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
	
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late,undertime,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$dates."','".$userid."','".$todayworkinghourswithoutnightdiff."','".$todaynightdiffhours."','".$Regulat_OT."','".$OT_with_night_diff."','".$late_hours."','".$undertimehour."','".$sixthday."','".$seventhday."')");
	mysqli_query($con,"insert into hourstable (shiftdate,dates,userid,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,sixth_ot_hours,seventh_ot_hours) values('".$dates."','".$datetomorrow."','".$userid."','".$tomwithoutnightdiff."','".$tomnightdiffhours."','0','0','".$sixthday."','".$seventhday."')" );
	
	

	}
}
*/
?>
