<?php
session_start();
if(!isset($_SESSION['Username'])){
header("location:index.php");
}
include('db_connect.php');
?>

<?php
if(isset($_GET['todo']) && $_GET['todo']=='10')
{
?>
<form action = "" method = "get">
  <p>Check Log</p>
       <p>
         <select name="Month">
           <option value="00">Month</option>
           <option value="1">January</option>
           <option value="2">February</option>
           <option value="3">March</option>
           <option value="4">April</option>
           <option value="5">May</option>
           <option value="6">June</option>
           <option value="7">July</option>
           <option value="8">August</option>
           <option value="9">September</option>
           <option value="10">October</option>
           <option value="11">November</option>
           <option value="12">December</option>
         </select>
         
         <select name="Day">
           <option value="0">Start Day</option>
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="5">5</option>
           <option value="6">6</option>
           <option value="7">7</option>
           <option value="8">8</option>
           <option value="9">9</option>
           <option value="10">10</option>
           <option value="11">11</option>
           <option value="12">12</option>
           <option value="13">13</option>
           <option value="14">14</option>
           <option value="15">15</option>
           <option value="16">16</option>
           <option value="17">17</option>
           <option value="18">18</option>
           <option value="19">19</option>
           <option value="20">20</option>
           <option value="21">21</option>
           <option value="22">22</option>
           <option value="23">23</option>
           <option value="24">24</option>
           <option value="25">25</option>
           <option value="26">26</option>
           <option value="27">27</option>
           <option value="28">28</option>
           <option value="29">29</option>
           <option value="30">30</option>        
           <option value="31">31</option>                                                                                     
         </select> 
         <input type = "hidden" name ="todo" value = "15"/>
         <input type="submit" name="generate" value="View Logs" />
       </p>
</form> 
<?php
}
if($_GET['todo'] && $_GET['todo']=='15')
{
  	echo $_GET['Month']." ".$_GET['Day']." ";
	echo $_SESSION['Username'];
?>
<form action = "" method = "get">
         <select name="Agent">
           <option value="00">Agent</option>
<?php

   		$result =mysqli_query($con,"SELECT * from userlogin WHERE department = 'Operations'");
		while($row = mysqli_fetch_array($result))
		   {  
?>           
           <option value="<?php echo $row['Username'];?>"><?php echo $row['Username'];?></option>
<?php
		   }
		   
?>      
         </select>   
         <input type = "hidden" name ="todo" value = "25"/>
         <input type="submit" name="generate" value="View Agent Log" />

</form> 
<?php	
}
if($_GET['todo'] && $_GET['todo']=='25')
{
	/***CALENDER.PHP(Reymund)**/
$month=$_GET['Month'];
$year=2010;
$userid=$_GET['Agent'];
//$userid=1000091;
echo $month;
$days_in_month=31;
//echo $days_in_month;
//echo "<br>";
$lastdays=$days_in_month-15;
//echo $lastdays;

#echo generate_calendar($year, $month, $days,$day_name_length,$month_href,$first_day,$pn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>

<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/jquery.editinplace.js"></script>
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
<table border="1" style="border-style:solid;" cellpadding="3">
<tr><td colspan="9"><strong><?php echo date('F',mktime(0, 0, 0, $month, 1, $year)); ?> 16-<?php echo $days_in_month; ?></strong></td></tr>
<tr style="text-align: center">
<td colspan="2"><strong>Day</strong></td>
<td width="150" ><strong>Status</strong></td>
<td width="150"><strong>Early Time</strong></td>
<td width="150"><strong>Start Shift</strong></td>
<!--<td width="150"><strong>Out</strong></td>
<td width="150"><strong>IN</strong></td>!-->
<td width="150"><strong>End Shift</strong></td>
<td width="150"><strong>OT Start</strong></td>
<td width="150"><strong>OT End</strong></td>
</tr >
<?php
for($x=$_GET['Day'];$x<=$days_in_month;$x++){
	?>
		<script>
        $(document).ready(function(){
			$(".edit_status_<?php echo $x; ?>").editInPlace({
			url: "server.php",
        	field_type: "select",
		 	success: function(newEditorContentString){
				if(newEditorContentString=="6th day OT"){
				$('#statuschanger_<?php echo $x; ?>').removeClass('absent');
				$('#statuschanger_<?php echo $x; ?>').removeClass('restday');
				$('#statuschanger_<?php echo $x; ?>').removeClass('present');
				$('#statuschanger_<?php echo $x; ?>').addClass('ot');
				}
				else if(newEditorContentString=="7th day OT"){
				$('#statuschanger_<?php echo $x; ?>').removeClass('absent');
				$('#statuschanger_<?php echo $x; ?>').removeClass('restday');
				$('#statuschanger_<?php echo $x; ?>').removeClass('present');
				$('#statuschanger_<?php echo $x; ?>').addClass('ot');
				}
				else if(newEditorContentString=='Absent'){
					$('#statuschanger_<?php echo $x; ?>').removeClass('ot');
					$('#statuschanger_<?php echo $x; ?>').removeClass('restday');
					$('#statuschanger_<?php echo $x; ?>').removeClass('present');
					$('#statuschanger_<?php echo $x; ?>').addClass('absent');
				}
				else if(newEditorContentString=='Restday'){
					$('#statuschanger_<?php echo $x; ?>').removeClass('ot');
					$('#statuschanger_<?php echo $x; ?>').removeClass('absent');
					$('#statuschanger_<?php echo $x; ?>').removeClass('present');
					$('#statuschanger_<?php echo $x; ?>').addClass('restday');
				
					}	
				else{
					$('#statuschanger_<?php echo $x; ?>').removeClass('ot');
					$('#statuschanger_<?php echo $x; ?>').removeClass('absent');
					$('#statuschanger_<?php echo $x; ?>').removeClass('restday');
					$('#statuschanger_<?php echo $x; ?>').addClass('present');
					}
			},	
			//	show_buttons: true,
				select_options: "Present,Absent,Restday,6th day OT,7th day OT,Vacation Leave,Sick Leave"
		});
		
		
		
		$(".edit_earlydatetime_<?php echo $x; ?>").editInPlace({
        	url: "server.php",
			show_buttons: true
        });
		$(".edit_startshift_<?php echo $x; ?>").editInPlace({
        	url: "server.php",
        	show_buttons: true
        });
		
		/*$(".edit_startlunch_<?=$x?>").editInPlace({
        	url: "server.php",
        	show_buttons: true
        });
		
		
		$(".edit_endlunch_<?=$x?>").editInPlace({
        	url: "server.php",
        	show_buttons: true
        });
		*/
		$(".edit_endshift_<?php echo $x; ?>").editInPlace({
        	url: "server.php",
        	show_buttons: true
        });
		
		
		$(".edit_obstart_<?php echo $x; ?>").editInPlace({
        	url: "server.php",
         	show_buttons: true
        });
		
		$(".edit_obend_<?php echo $x; ?>").editInPlace({
        	url: "server.php",
        	show_buttons: true
        });
		
		});
		</script>   
        
     
    <?php
	$day=date('D',mktime(0, 0, 0, $month, $x, $year));
	
	$getdata2="select * from timelog where userid='".$userid."' and dates='".$year."-".$month."-".$x."' order by dates asc";
	
	$getdata=mysqli_query($con,$getdata2);
	if (mysqli_num_rows($getdata) == 0)
		{
			$getempployeescked="select groupschedule.*,prlemployeemaster.schedule from groupschedule,prlemployeemaster where prlemployeemaster.schedule=groupschedule.groupschedulename and RFID='".$userid."'";
			//echo $getempployeescked."<br>";
			$getempployeescked=mysqli_query($con,$getempployeescked);
				while($employeesked=mysqli_fetch_array($getempployeescked)){
				/*if($employeesked[$day]=='1')
				{
					$status="Absent";
					
					}
				else{
					$status="Restday";
					}*/
					$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$year."-".$month."-".$x."','".$day."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";
					//echo $insert."<br>";
					mysqli_query($con,$insert);
					//echo '<META HTTP-EQUIV="refresh" CONTENT="0; URL=calendar.php">'; 
					//exit();
				}
			
			?>
            <tr <?php if($status=='Absent'){ echo 'class="absent"';} else { echo 'class="restday"';}?> height="25">
                <td><strong>
                <?php echo $day; ?>
                </strong></td>
                <td><?php echo $x; ?></td>
                <td><p class="edit_status_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_editstatus"><?php echo $status; ?></p></td>
                <td style="text-align: center"><?php echo $rowgetdata['earlytimedate']; ?></td>
                <td style="text-align: center"><?php echo $rowgetdata['startshift']; ?></td>
                <td style="text-align: center"><?php echo $rowgetdata['endshift']; ?></td>
                <td style="text-align: center"><?php echo $rowgetdata['otstart']; ?></td>
                <td style="text-align: center"><?php echo $rowgetdata['otend']; ?></td>
   			</tr>
            <?php
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
                <tr <?php if($status=='Present'){ echo 'class="present"';} 
				else if($status=='Absent'){ echo 'class="absent"';} 
				else if($status=='Restday'){ echo 'class="restday"';} 
				else { echo 'class="ot"';}?> id="statuschanger_<?php echo $x; ?>"  height="40" >
                    <td><strong>
                    <?php echo $day; ?>
                    </strong></td>
                    <td><?php echo $x; ?></td>
                    <td><p class="edit_status_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_editstatus"><?php echo $status; ?></p></td>
                	<td style="text-align: center">
					<?php
					
                   // $earlytimedate=explode(" ",$rowgetdata['earlytimedate']);
					?>
                    <font class="edit_earlydatetime_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_changeearlydatetime"><?php echo $rowgetdata['earlytimedate']; ?></font>
                    <!--<font class="edit_earlydate_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeearlydate"><?=$earlytimedate[0]?></font>                    <font class="edit_earlytime_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeearlytime"><?=$earlytimedate[1]?></font>!-->
                   

	
                    </td>
                    <td style="text-align: center">
					<font class="edit_startshift_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_changestartshift"><?php echo $rowgetdata['startshift']; ?></font>
				  </td>
                  <!--
                  <td style="text-align: center">
					<font class="edit_startlunch_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changelunchstart"><?=$rowgetdata['startlunch']?></font>
				  </td>
                  <td style="text-align: center"><font class="edit_endlunch_<?=$x?>" id="<?=$year?>_<?=$month?>_<?=$x?>_<?=$userid?>_changeendlunch"><?=$rowgetdata['endlunch']?></font></td>
                  !-->
                  <td style="text-align: center"><font class="edit_endshift_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_changeendshift"><?php echo $rowgetdata['endshift']; ?></font></td>
                  <td style="text-align: center"><font class="edit_obstart_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_changeotstart"><?php echo $rowgetdata['otstart']; ?></font></td>
                    <td style="text-align: center"><font class="edit_obend_<?php echo $x; ?>" id="<?php echo $year; ?>_<?php echo $month; ?>_<?php echo $x; ?>_<?php echo $userid; ?>_changeotend"><?php echo $rowgetdata['otend']; ?></font></td>
               	</tr>
             <?php	
			
			
			}
		
		}	
	
	}	
	
}

?>
</body>
</html>