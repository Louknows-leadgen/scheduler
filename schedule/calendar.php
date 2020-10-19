<?php

	session_start();
	ob_start();

	include('db_connect.php');

	$pmonth=$_POST['month'];
	$ppayperiod=$_POST['payperiod'];
	$pyear=$_POST['year']; 
	$approve=0;
	$message = '';

	$checkifapproved=mysqli_query($con,"select * from approved_payperiods where payperiod='".$pyear."-".$pmonth."-".$ppayperiod."' and employeeid='".$_POST['employeeid']."'");
	$checknum=mysqli_num_rows($checkifapproved);

	if($checknum>=1){
		$message="This has already been approved";
		$approve='1';
	}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_POST['employeeid']?> <?php echo $_GET['employeeid']?> - <?php echo $_POST['agentname']?> <?php echo $_POST['agenltname']?> <?php echo $_GET['agentname']?> <?php echo $_GET['agenltname']?>'s Schedule</title>
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>

<script type="text/javascript" src="js/jquery.ui.js"></script>
<?php if($approve!='1'){ ?>
<script type="text/javascript" src="js/jquery.editinplace.js"></script>
<?php } ?>
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
<?php


if(($_POST['month']!='' && $_POST['year']!='' && $_POST['employeeid']!='' && $_POST['payperiod']!='')||($_GET['month']!='' && $_GET['year']!='' && $_GET['employeeid']!='' && $_GET['payperiod']!='')){
	if($_GET['employeeid']!=''){
		$month=$_GET['month'];
		$year=$_GET['year'];
		$userid=$_GET['employeeid'];

		if($_GET['payperiod']=='10'){ 
			$startday=16;
	
			if($month=='01'){
				$month='12';
				$year=$_GET['year']-1;
			}else{
				$month=$month-1;
			}	

		    $days_in_month=30;
			$enddays=30;
			echo "'.$startday.'";
			echo "'.$startday.'";
		}else{
			$startday=1;
			$enddays=15;
			echo "'.$startday.'";
			echo "'.$startday.'";
		}
	}else{		
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
	
			if($month=='01'){
				$month='12';
				$year=$_POST['year']-1;
			}else{
				$month=$month-1;
			}	
			
			$days_in_month=30;
			$enddays=$days_in_month;
		}else{
			$startday=1;	
			$enddays=15;
		}	
	}

?>

	<font color="#00CC00" size="+1"><?php echo $message?></font>
	<table border="1" style="border-style:solid;" cellpadding="3">
		<tr bgcolor="#999999">
			<td colspan="9">
				<strong>
					<?php echo $_POST['employeeid']?> <?php echo $_GET['employeeid']?> - <?php echo $_POST['agentname']?> <?php echo $_POST['agenltname']?> <?php echo $_GET['agentname']?> <?php echo $_GET['agenltname']?>
				</strong>
			</td>
		</tr>
		<tr bgcolor="#999999">
			<td colspan="9">
				<strong>
					<?php echo date('F',mktime(0, 0, 0, $month, 1, $year))?> <?php echo $startday?>-<?php echo $enddays?> <?php echo $year?>
				</strong>
			</td>
		</tr>
		<tr style="text-align: center"  bgcolor="#999999">
			<td colspan="2"><strong>Day</strong></td>
			<td width="150" ><strong>Status</strong></td>
			<td width="150"><strong>Early Time</strong></td>
			<td width="150"><strong>Start Shift</strong></td>
			<td width="150"><strong>End Shift</strong></td>
			<td width="150"><strong>OT Start</strong></td>
			<td width="150"><strong>OT End</strong></td>
			<td width="150"><strong>Shift</strong></td>
		</tr >

	<?php 
		for($x=$startday;$x<=$enddays;$x++){ 
	?>
			<script>
		        $(document).ready(function(){
					$(".edit_status_<?php echo $x?>").editInPlace({
						url: "server.php",
			        	field_type: "select",
					 	success: function(newEditorContentString){
							if(newEditorContentString=="6th day OT"){
							$('#statuschanger_<?php echo $x?>').removeClass('absent');
							$('#statuschanger_<?php echo $x?>').removeClass('restday');
							$('#statuschanger_<?php echo $x?>').removeClass('present');
							$('#statuschanger_<?php echo $x?>').addClass('ot');
							}
							else if(newEditorContentString=="7th day OT"){
							$('#statuschanger_<?php echo $x?>').removeClass('absent');
							$('#statuschanger_<?php echo $x?>').removeClass('restday');
							$('#statuschanger_<?php echo $x?>').removeClass('present');
							$('#statuschanger_<?php echo $x?>').addClass('ot');
							}
							else if(newEditorContentString=='Absent'){
								$('#statuschanger_<?php echo $x?>').removeClass('ot');
								$('#statuschanger_<?php echo $x?>').removeClass('restday');
								$('#statuschanger_<?php echo $x?>').removeClass('present');
								$('#statuschanger_<?php echo $x?>').addClass('absent');
							}
							else if(newEditorContentString=='Restday'){
								$('#statuschanger_<?php echo $x?>').removeClass('ot');
								$('#statuschanger_<?php echo $x?>').removeClass('absent');
								$('#statuschanger_<?php echo $x?>').removeClass('present');
								$('#statuschanger_<?php echo $x?>').addClass('restday');
							
								}	
							else{
								$('#statuschanger_<?php echo $x?>').removeClass('ot');
								$('#statuschanger_<?php echo $x?>').removeClass('absent');
								$('#statuschanger_<?php echo $x?>').removeClass('restday');
								$('#statuschanger_<?php echo $x?>').addClass('present');
								}
						},	
						<?php
							$selectoptions='Present,Absent';
							if($_SESSION['Level']=='3'){
								$selectoptions.=",Restday,Holiday Off,6th day OT,7th day OT,Vacation Leave,Wedding Leave,Sick Leave,PSUP, USUP,Comp-Off,BVMT Leave,HOLI,LOAU,LPAT,NCNS,SKUNP,BVMT,BVUNP,LMAT,LOAM,MARRIAGE LEAVE";
							}else if($_SESSION['Level']=='4'){
								$selectoptions.=",Restday,6th day OT,7th day OT";
							}					
						?>
						select_options: "<?php echo $selectoptions?>"
					});
			
			
					$(".edit_thisshift_<?php echo $x?>").editInPlace({
						url: "server.php",
		        		field_type: "select",
				 		success: function(newEditorContentString){
						},	
						select_options: "<?php 
						$zz=1;
						$getsched=mysqli_query($con,"select groupschedulename,starttime,endtime from groupschedule ORDER BY groupschedulename asc");
						while($rowgroup=mysqli_fetch_array($getsched)){
							if($z>0)
							{
								echo ",".$rowgroup['groupschedulename'];
								}
							else{
								echo $rowgroup['groupschedulename'];
								}	
							$z++;
							}
						?>"
					});
				
			
					$(".edit_earlydatetime_<?php echo $x?>").editInPlace({
			        	url: "server.php",
						show_buttons: true
			        });
				

					$(".edit_startshift_<?php echo $x?>").editInPlace({
			        	url: "server.php",
			        	show_buttons: true
			        });
				

					$(".edit_endshift_<?php echo $x?>").editInPlace({
			        	url: "server.php",
			        	show_buttons: true
			        });
				
				
					$(".edit_obstart_<?php echo $x?>").editInPlace({
			        	url: "server.php",
			         	show_buttons: true
			        });
				

					$(".edit_obend_<?php echo $x?>").editInPlace({
			        	url: "server.php",
			        	show_buttons: true
			        });
			
				});
			</script>   
<?php
			$day=date('D',mktime(0, 0, 0, $month, $x, $year));
			$getdata2="select * from timelog where userid='".$userid."' and dates='".$year."-".$month."-".$x."' order by dates asc";
			$getdata=mysqli_query($con,$getdata2);
			$numrowsdaws=mysqli_num_rows($getdata);
		
			if($numrowsdaws <= 0){
				$getempployeescked="select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and employeeid='".$userid."'";
				$getempployeescked=mysqli_query($con,$getempployeescked);
				while($employeesked=mysqli_fetch_array($getempployeescked)){
					if($employeesked[$day]=='1'){
						$status="Absent";				
					}else{
						$status="Restday";
					}

					if($employeesked['otherday']=='1'){
						$datesupposetobe2=$year."-".$month."-".$x;
						$datesshit[]=$datesupposetobe2;
						
						//$supposedate = strtotime(date("Y-m-d", strtotime($datesupposetobe)) . " +1 day");
						
						$thisissupposetobe=date('Y-m-d', strtotime($datesupposetobe2) + 86400);
						$datesshit2[]=$thisissupposetobe;
						
						$startskeddaw="".$year."-".$month."-".$x." ".$employeesked['starttime'];
						//$endskeddaw="".$year."-".$month."-".$dayshiftendsuppose." ".$employeesked['endtime'];
						$endskeddaw=$thisissupposetobe." ".$employeesked['endtime'];
						
						$startshift=$year."-".$month."-".$x." ".$employeesked['starttime'];
						$endshift=$thisissupposetobe." ".$employeesked['endtime'];
						//$endskeddaw;
						
					}else{
						$dayshiftendsuppose=$x;
						$startskeddaw="".$year."-".$month."-".$x." ".$employeesked['starttime'];
						$endskeddaw="".$year."-".$month."-".$dayshiftendsuppose." ".$employeesked['endtime'];
						
						$startshift="".$year."-".$month."-".$x." ".$employeesked['starttime'];
						$endshift="".$year."-".$month."-".$dayshiftendsuppose." ".$employeesked['endtime'];
						
					}

					$timein = isset($timein)   && !empty($timein)  && $timein != '0000-00-00 00:00:00' ? $timein : '1900-01-01 00:00:00';
					$timeout = isset($timeout) && !empty($timeout) && $timeout != '0000-00-00 00:00:00' ? $timeout : '1900-01-01 00:00:00';
					$earlytimedate = isset($earlytimedate) && !empty($earlytimedate) && $earlytimedate != '0000-00-00 00:00:00' ? $earlytimedate : '1900-01-01 00:00:00';
					$otstart = isset($otstart) && !empty($otstart) && $otstart != '0000-00-00 00:00:00' ? $otstart : '1900-01-01 00:00:00';
					$otend = isset($otend)     && !empty($otend)   && $otend != '0000-00-00 00:00:00' ? $otend : '1900-01-01 00:00:00';

					$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`,`thisdaysshift`)values('".$year."-".$month."-".$x."','".$day."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."','".$schedule."')";
					echo $insert."<br>";
					mysqli_query($con,$insert);

					header('location:calendar.php?month='.$_POST['month'].'&year='.$_POST['year'].'&employeeid='.$_POST['employeeid'].'&payperiod='.$_POST['payperiod'].'&agentname='.$_POST['agentname'].'&agenltname='.$_POST['agenltname'].'');
						//echo "asdasd";
						//echo '<META HTTP-EQUIV="refresh" CONTENT="0; URL=calendar.php">'; 
						//exit();
				}		
?>
	            <tr <?php if($status=='Absent'){ echo 'class="absent"';} else { echo 'class="restday"';}?> height="25">
	                <td><strong><?php echo $day?></strong></td>
	                <td><?php echo $x?></td>
	                <td><p class="edit_status_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_editstatus"><?php echo $status?></p></td>
	                <td style="text-align: center"><?php echo $rowgetdata['earlytimedate']?></td>
	                <td style="text-align: center"><?php echo $rowgetdata['startshift']?></td>
	                <td style="text-align: center"><?php echo $rowgetdata['endshift']?></td>
	                <td style="text-align: center"><?php echo $rowgetdata['otstart']?></td>
	                <td style="text-align: center"><?php echo $rowgetdata['otend']?></td>
	                <?php
	                	if($_SESSION['Level']=='3' || $_SESSION['Level']=='4'){
					?>
							<td>
								<p class="edit_thisshift_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_thisshift"><?php echo $rowgetdata['thisdaysshift']?></p>
							</td>
	                <?php
						}else{
							echo "<td>" . $rowgetdata['thisdaysshift'] . "</p></td>";
		                }
	                ?>
	   			</tr>
<?php
			}else{
				while($rowgetdata=mysqli_fetch_array($getdata))
				{
					$status=$rowgetdata['status'];
?>
	                <tr <?php 
	                		if($status=='Present'){ 
	                			echo 'class="present"';
	                		}else if($status=='Absent'){ 
	                			echo 'class="absent"';
	                		}else if($status=='Restday'){ 
	                			echo 'class="restday"';
	                		}else{ 
	                			echo 'class="ot"';
	                		}
	                	?> 
	                	id="statuschanger_<?php echo $x?>"  
	                	height="40" >
	                    <td><strong><?php echo $day?></strong></td>
	                    <td><?php echo $x?></td>
	                    <td><p class="edit_status_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_editstatus"><?php echo $status?></p></td>
	                	<td style="text-align: center">
	                    	<font class="edit_earlydatetime_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_changeearlydatetime"><?php echo $rowgetdata['earlytimedate']?>
	                    	</font>
	                   	</td>
	                    <td style="text-align: center">
							<font class="edit_startshift_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_changestartshift"><?php echo $rowgetdata['startshift']?>
							</font>
					  	</td>
	                  	<td style="text-align: center">
	                  		<font class="edit_endshift_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_changeendshift"><?php echo $rowgetdata['endshift']?>
	                  		</font>
	                  	</td>
	                  	<td style="text-align: center">
	                  		<font class="edit_obstart_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_changeotstart"><?php echo $rowgetdata['otstart']?>
	                  		</font>
	                  	</td>
	                    <td style="text-align: center">
	                    	<font class="edit_obend_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_changeotend"><?php echo $rowgetdata['otend']?>
	                    	</font>
	                    </td>
	                    
						<?php
	                		if($_SESSION['Level']=='3' || $_SESSION['Level']=='4') {
						?> 
								<td>
									<p class="edit_thisshift_<?php echo $x?>" id="<?php echo $year?>_<?php echo $month?>_<?php echo $x?>_<?php echo $userid?>_thisshift"><?php echo $rowgetdata['thisdaysshift']?></p>
								</td>
	                    <?php 
	                		}else{
						?>
	                       		<td> <?php echo $rowgetdata['thisdaysshift']?></td>
	                    <?php
							}
						?>
	               	</tr>
<?php	
				}
			}	
		}// end of for loop
?>

	</table>
<?php 
}else{
	echo "Please select month, payperiod and year";
}
	
	print_r($datesshit);
	echo "<br>";
	print_r($datesshit2);

?>
</body>
</html>

