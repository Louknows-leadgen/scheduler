<?php
session_start();
ob_start();
include("db_connect.php");
/*
print_r($_POST['dates']);
echo "<br>";echo "<br>";

print_r($_POST['approve']);
echo "<br>";echo "<br>";
print_r($_POST['approvewithnd']);
*/
$dates=$_POST['dates'];
$approve=$_POST['approve'];
$approvewithnd=$_POST['approvewithnd'];
$approveearly=$_POST['approveearly'];
$employeeid=$_POST['employeeid'];
$payperiod=$_POST['payperiod'];
$status=$_POST['status'];

//print_r($_POST['dates']);
//print_r($approve);
/*echo "approve<br>";
print_r($approve);
echo "<br>";
echo "approveearly<br>";
print_r($approveearly);
echo "<br>";
echo "approvewithnd<br>";
print_r($approvewithnd);
//echo "<br>";
*/

$counting=count($dates);

for($x=0;$x<$counting;$x++){
	
	/*$checkhours=mysqli_query($con,"select * from finalhourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'");
	//echo "select * from hourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'<br>";
	$numcheckhours=mysqli_num_rows($checkhours);
	$gethours=mysqli_query($con,"select * from hourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'");
	if($numcheckhours<=0){
		$z=1;
			while($rowhours=mysqli_fetch_array($gethours))
			{
				if($z=='1')
				{
				
				mysqli_query($con,"insert into finalhourstable(shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late, 	undertime,sixth_ot_hours,seventh_ot_hours,status) values ('".$rowhours['shiftdate']."','".$rowhours['dates']."','".$rowhours['userid']."','".$approveearly[$x]."','".$rowhours['regular_hours']."','".$rowhours['nightdiff_hours']."','0','0','".$rowhours['late']."','".$rowhours['undertime']."','".$rowhours['sixth_ot_hours']."','".$rowhours['seventh_ot_hours']."','".$status[$x]."')");
				}
				else{
					
					mysqli_query($con,"insert into finalhourstable(shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late, 	undertime,sixth_ot_hours,seventh_ot_hours,status) values ('".$rowhours['shiftdate']."','".$rowhours['dates']."','".$rowhours['userid']."','0','".$rowhours['regular_hours']."','".$rowhours['nightdiff_hours']."','".$approve[$x]."','".$approvewithnd[$x]."','".$rowhours['late']."','".$rowhours['undertime']."','".$rowhours['sixth_ot_hours']."','".$rowhours['seventh_ot_hours']."','".$status[$x]."')");
					}
			$z++;
			}
	}
	else{
	$gethours=mysqli_query($con,"select * from hourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'");
	
		$z=1;
			while($rowhours=mysqli_fetch_array($gethours))
			{
				if($z=='1')
				{
					mysqli_query($con,"update finalhourstable set early='".$approveearly[$x]."' where shiftdate='".$dates[$x]."' and userid='".$employeeid."' and dates='".$rowhours['dates']."'" );
				}
				else {
					mysqli_query($con,"update finalhourstable set regular_ot_hours='".$approve[$x]."',nightdiff_ot_hours='".$approvewithnd[$x]."' where shiftdate='".$dates[$x]."' and userid='".$employeeid."' and dates='".$rowhours['dates']."'");
					}
			$z++;		
			//}
	}
	
*/


	
	$checkhours=mysqli_query($con,"select * from finalhourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'");
	//echo "select * from hourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'<br>";
	$numcheckhours=mysqli_num_rows($checkhours);
	$gethours="select * from hourstable where shiftdate='".$dates[$x]."' and userid='".$employeeid."'";
	//echo gethours
	$gethours=mysqli_query($con,$gethours);
	if($numcheckhours<=0){
		$z=1;
			while($rowhours=mysqli_fetch_array($gethours))
			{
				if($z=='1')
				{
				
				mysqli_query($con,"insert into finalhourstable(shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late, 	undertime,sixth_ot_hours,seventh_ot_hours,status) values ('".$rowhours['shiftdate']."','".$rowhours['dates']."','".$rowhours['userid']."','".$approveearly[$x]."','".$rowhours['regular_hours']."','".$rowhours['nightdiff_hours']."','0','0','".$rowhours['late']."','".$rowhours['undertime']."','".$rowhours['sixth_ot_hours']."','".$rowhours['seventh_ot_hours']."','".$rowhours['status']."')");
				}
				else{
					
					mysqli_query($con,"insert into finalhourstable(shiftdate,dates,userid,early,regular_hours,nightdiff_hours,regular_ot_hours,nightdiff_ot_hours,late, 	undertime,sixth_ot_hours,seventh_ot_hours,status) values ('".$rowhours['shiftdate']."','".$rowhours['dates']."','".$rowhours['userid']."','0','".$rowhours['regular_hours']."','".$rowhours['nightdiff_hours']."','".$approve[$x]."','".$approvewithnd[$x]."','".$rowhours['late']."','".$rowhours['undertime']."','".$rowhours['sixth_ot_hours']."','".$rowhours['seventh_ot_hours']."','".$rowhours['status']."')");
					}
			$z++;
			}
	}
	else{
		$z=1;
			while($rowhours=mysqli_fetch_array($gethours))
			{
				if($z=='1')
				{
					mysqli_query($con,"update finalhourstable set early='".$approveearly[$x]."' where shiftdate='".$dates[$x]."' and userid='".$employeeid."'" );
				}
				else {
					mysqli_query($con,"update finalhourstable set regular_ot_hours='".$approve[$x]."',nightdiff_ot_hours='".$approvewithnd[$x]."' where shiftdate='".$dates[$x]."' and userid='".$employeeid."' and dates='".$rowhours['dates']."'");
					}
			$z++;		
			}
	}


}

mysqli_query($con,"insert into approvehours_history (Name,ipaddress,payperiod,employeeid) values ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$payperiod."','".$employeeid."')");

//echo "insert into approvehours_history (Name,ipaddress,payperiod,employeeid) values ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$payperiod."','".$employeeid."')";
//echo "select * from approved_payperiods where payperiod='".$payperiod."' and employeeid='".$employeeid."'";
$checkpayperiods=mysqli_query($con,"select * from approved_payperiods where payperiod='".$payperiod."' and employeeid='".$employeeid."'");
$numcheckpayperiods=mysqli_num_rows($checkpayperiods);
	if($numcheckpayperiods<=0){
			mysqli_query($con,"insert into approved_payperiods (payperiod,employeeid,TLapproved,WFMapproved) values ('".$payperiod."','".$employeeid."','1','0')");
	}

	else{
		mysqli_query($con,"update approved_payperiods TLapproved='1' where payperiod='".$payperiod."' and employeeid='".$employeeid."'");
	}
	
	?>
    <style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
    <?php
	
echo "<center><h3>Hours Has been approved!</h3><br />
(You may now close this window)</center>";	


ob_end_flush();
?>