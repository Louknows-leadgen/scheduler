<?php
include("db_connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php

$result = mysqli_query($con,"SELECT * FROM teamassignment WHERE teamlead ='41' order by employeeid asc");
	 while($rowdata = mysqli_fetch_array($result))
		   {
			   $resultemp = mysqli_query($con,"SELECT lastname, firstname FROM prlemployeemaster WHERE employeeid = '".$rowdata['employeeid']."'");
			   $rowemp = mysqli_fetch_array($resultemp);
			   
			     $ctr = 0;
				 $total = 0;
			   
?>
   <table border="1">
   <tr>
   <td align="center" colspan="10"><? echo $rowdata['employeeid']." : ".$rowemp['lastname'].", ".$rowemp['firstname']." <br />"; ?></td> 
   </tr>
   <tr>
   <td width="100" align="center"> ShiftDate </td>
   <td width="100" align="center"> TimeIn </td>
   <td width="100" align="center"> TimeOut </td>
   <td width="80" align="center"> Late </td>    
   <td width="94" align="center"> Undertime </td>
   <td width="91" align="center"> Status </td>
   <td width="100" align="center"> WorkingMinutes </td>
   <td width="100" align="center"> WorkedMinutes </td>
   <td width="100" align="center"> ApprovedLeave </td>
   <td width="100" align="center"> Absenteeism </td>
   </tr>
<?			 
			 
			 $resultlog = mysqli_query($con,"SELECT *,sum(late) as latesum, sum(undertime) as undertimesum FROM hourstable WHERE userid = '".$rowdata['employeeid']."' AND shiftdate >= '2013-03-01' AND shiftdate <= '2013-04-31' group by shiftdate");
			   while($rowlog = mysqli_fetch_array($resultlog))
			     {
					 $resuldate = mysqli_query($con,"SELECT dates, userid, startshift, endshift FROM timelog WHERE userid = '".$rowdata['employeeid']."' AND dates = '".$rowlog['shiftdate']."'");
			          $rowdate = mysqli_fetch_array($resuldate);
					  
					$ctr = $ctr + 1;
					
					  
					 
					 echo "<tr>";
					echo "<td align = 'center'>".$rowlog['shiftdate']."</td>";
					echo "<td align = 'center'>".$rowdate['startshift']."</td>";
					echo "<td align = 'center'>".$rowdate['endshift']."</td>";					
					 $workminutes =   ($rowlog['latesum'] + $rowlog['undertimesum']) * 60;
					 $workminutes = 480 - $workminutes;					
					
					if ($rowlog['latesum'] > '0')
					{
						echo "<td align = 'center' style='color:RED;'>".$rowlog['latesum']."</td>";
					    echo "<td align = 'center' style='color:RED;'>".$rowlog['undertimesum']."</td>";
						echo "<td align = 'center' style='color:RED;'> Tardy </td>";
						echo "<td align = 'center'> 480 Mins </td>";
						echo "<td align = 'center' style='color:RED;'>".$workminutes."</td>";
						echo "<td align = 'center'> 0 </td>";
						 $absenteeism = (($workminutes)/ 480) * 100 ;
						 echo "<td align = 'center' style='color:RED;'>".$absenteeism."%</td>";
						 $total = $total + $absenteeism;
					}
					else if ($rowlog['undertimesum'] > '0')
					{
						echo "<td align = 'center' style='color:RED;'>".$rowlog['latesum']."</td>";
					    echo "<td align = 'center' style='color:RED;'>".$rowlog['undertimesum']."</td>";
						echo "<td align = 'center' style='color:RED;'> Undertime </td>";
						echo "<td align = 'center'> 480 Mins </td>";
						echo "<td align = 'center' style='color:RED;'>".$workminutes."</td>";
						echo "<td align = 'center'> 0 </td>";
						$absenteeism = (($workminutes)/ 480) * 100 ;
						 echo "<td align = 'center' style='color:RED;'>".$absenteeism."%</td>";
						 $total = $total + $absenteeism;
					}
					else
					{
						echo "<td align = 'center'>".$rowlog['latesum']."</td>";
					    echo "<td align = 'center'>".$rowlog['undertimesum']."</td>";
						
						if ($rowlog['status'] == 'Absent')   
						{
						 echo "<td align = 'center' style='color:RED;'>".$rowlog['status']."</td>";
						 echo "<td align = 'center'> 480 Mins </td>";
						 echo "<td align = 'center' style='color:RED;'> 0 </td>";
						 echo "<td align = 'center' style='color:RED;'> 0 </td>";
						 $absenteeism = 0 ;
						 echo "<td align = 'center' style='color:RED;'> 0% </td>";
						 
						}
						else if ($rowlog['status'] == 'Comp-Off' || $rowlog['status'] == 'Vacation Leave')   
						{
						 echo "<td align = 'center' style='color:GREEN;'>".$rowlog['status']."</td>";
						 echo "<td align = 'center'> 480 Mins </td>";
						 echo "<td align = 'center' style='color:RED;'> 0 </td>";
						 echo "<td align = 'center' style='color:GREEN;'> 480 Mins </td>";
						 $absenteeism = (($workminutes)/ 480) * 100  ;
						 echo "<td align = 'center'>".$absenteeism ."%</td>";
						 $total = $total + $absenteeism;
						}
						else if ($rowlog['status'] == 'Restday')   
						{
						 echo "<td align = 'center' style='color:GRAY;'>".$rowlog['status']."</td>";
						 echo "<td align = 'center'> 0 Mins </td>";
						 echo "<td align = 'center'> 0 </td>";
						 echo "<td align = 'center'> 0 </td>";
						 echo "<td align = 'center'>N/A</td>";
						 $ctr = $ctr - 1;
						}
						else
						{
							echo "<td align = 'center'>".$rowlog['status']."</td>";
							echo "<td align = 'center'> 480 Mins </td>";
							echo "<td align = 'center'>".$workminutes."</td>";
							echo "<td align = 'center'> 0 </td>";
							$absenteeism = (($workminutes)/ 480) * 100  ;
						    echo "<td align = 'center'>".$absenteeism ."%</td>";
							$total = $total + $absenteeism;
						}
					}
										
					 echo "</tr>";
					 
					 
					 
					 
			     }
				 
				 if($total != '0')
				 {
					 $total = $total/$ctr;
				 }
				 
				 
				 echo "<tr>";
				 echo "<td align = 'center' colspan = '9'> Absenteeism Summary </td>";
				 echo "<td align = 'center'>".$total."%</td>";
				 echo "</tr>";
				 echo "<br />";
				 echo "<br />";
			   
?>

</table>

<?
			 
			 
			 
		   }	

?>

<body>
</body>
</html>