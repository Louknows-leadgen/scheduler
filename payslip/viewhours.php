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
	color: #F00;
	font-weight: bold;
}
-->

<!--
 .absent { background-color: red;  }
  .restday { background-color: #CCCCCC }
  .highlight { background-color: #8888FF }
//-->


</style>
<font color="#00CC00" size="+1"><?=$message?></font>
<?
if($checknum>=1){
	?>
<form action="tlapprove.php" method="post">
<table border="1" cellpadding="2">
<tr bgcolor="#000000" style="color:#FFF">
				 <td>Date</td>
                <td>Reg H</td>
                <td>W/ ND</td>
                
                <td bgcolor="#00CC00" style="color:#000">A Early OT</td>
                <td>Late</td>
                <td>Undertime</td>
                
              <td bgcolor="#00CC00" style="color:#000">A RegOT</td>
               
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
	
	for($x=$startday;$x<=$enddays;$x++){
		

	$getfinalhours="select * from finalhourstable where userid='".$_POST['employeeid']."' and shiftdate='".$year."-".$month."-".$x."'";
	//echo $getfinalhours."<br>";
	$getfinalhours=mysqli_query($con,$getfinalhours);
	$thisdate='';
	$status='';
	$regular_hours=0;
	$regular_ot_hours=0;
	$nightdiff_ot_hours=0;
	$late=0;
	$undertime=0;
	$regular_hours=0;
	$nightdiff_hours=0;
	$early=0;
		$numfinalhours=mysqli_num_rows($getfinalhours);
	if($numfinalhours>0){	
	while($rowtimelogs=mysqli_fetch_array($getfinalhours)){
		$thisdate=$rowtimelogs['dates'];
		$status=$rowtimelogs['status'];
		$regular_hours=$rowtimelogs['regular_hours']+$regular_hours;
		$nightdiff_hours=$rowtimelogs['nightdiff_hours']+$nightdiff_hours;
		$early=$rowtimelogs['early']+$early;
		$undertime=$rowtimelogs['undertime']+$undertime;
		$regular_ot_hours=$rowtimelogs['regular_ot_hours']+$regular_ot_hours;
		$nightdiff_ot_hours=$rowtimelogs['nightdiff_ot_hours']+$nightdiff_ot_hours;
		$late=$rowtimelogs['late']+$late;
		//	echo 	"regular_hours - ".$regular_hours."<br>";
    }
	
	?>
		<tr bgcolor="<? if($status=='Restday'){ echo "#CCCCCC"; } if($status=='Vacation Leave'){ echo "yellowgreen"; } if($status=='Absent') { echo "red"; } if($status=='Present'){ echo "#FFFFFF"; }?>" onMouseOver="this.className='highlight'" onMouseOut="this.className='<? if($status=='Restday'){ echo "restday";} if($status=='Vacation Leave'){ echo "normal"; } if($status=='Absent') { echo "absent"; } if($status=='Present'){ echo "normal"; }?>'"> 
            	<td ><strong><?=$year."-".$month."-".$x?></strong></td>
            	<td><?=$regular_hours?></td>
                <td><?=$nightdiff_hours?></td>
                <td><?=$early?></td>
                <td <? if($late>0){ echo 'bgcolor="red"';} ?>><?=$late?></td>
                <td <? if($undertime>0){ echo "bgcolor='orange'";} ?>><?=$undertime?></td>
                <td><?=$regular_ot_hours?></td>
                <td><?=$nightdiff_ot_hours?></td>
            </tr>
	
    <?
    }
	else{
		?>
        <tr>
       	 <td ><strong><?=$year."-".$month."-".$x?></strong></td>
        	<td colspan="7">You don't get paid this day. Please ask for assistance fromk your TL/Supervisor.</td>
        </tr>
		<?
        }
	}
?>

</table>

<?
}

else{
	echo "<font color='red'><b>Sorry... You don't get your pay this pay period... Please ask assistance from your TLs/Supervisors.. Thank you!<b></font>";
}
?>