<?php
session_start();
include("db_connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/main.css" type="text/css" rel="stylesheet" media="screen" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<!--[if IE]><script type="text/javascript" src="jquery/excanvas.compiled.js"></script><![endif]-->
		<script type="text/javascript" src="jquery/visualize.jQuery.js"></script>
</head>

<body>


</table>


   <p>&nbsp;</p>
   
   <table border="1">
   <tr>
   <td align="center" colspan="8"> TransferrTracker </td> 
   </tr>
   <tr>
   <td width="114" align="center"> Phone </td> 
    <td width="91" align="center"> Course </td>
 <td width="122" align="center"> Category </td>
   <td width="243" align="center"> Zip </td>
   <td width="243" align="center"> First Name</td>
   <td width="103" align="center"> Last Name </td>
    <!--  <td width="95" align="center"> DOB </td>
   <td width="243" align="center"> Address </td>
   <td width="95" align="center"> IPAddress </td>
   <td width="243" align="center"> City </td>
   <td width="243" align="center"> Email </td>
   <td width="243" align="center"> ProgramOfInterest </td>
   <td width="243" align="center"> EducationLevel </td>
   <td width="243" align="center"> GEDIssued </td>
   <td width="243" align="center"> CurGED </td>
   <td width="243" align="center"> Military </td>
   <td width="243" align="center"> MilitaryAffiliation </td>
   <td width="243" align="center"> EnrollmentTarget </td>
   <td width="243" align="center"> Debt </td>
   <td width="243" align="center"> Transferredto </td>-->
   
   </tr>
<?
   $resultvalid =mysqli_query($con,"SELECT created,phone,course,first_name, last_name,zipcode,us_military FROM callhistories WHERE `created` > '2012-09-02 00:00:00' AND `created` < '2012-09-09 00:00:00' GROUP BY `phone` order by created desc");
   while($rowvalid = mysqli_fetch_array($resultvalid))
		{
			$getcode =mysqli_query($con,"SELECT * FROM programms WHERE id = '".$rowvalid['course']."'");
			$getboundcode = mysqli_fetch_array($getcode);
			
			
			echo "<tr>";
			echo "<td align = 'center'>".$rowvalid['phone']."</td>";
			echo "<td align = 'center'>".$getboundcode['program']."</td>";
			echo "<td align = 'center'>".$getboundcode['category']."</td>";
			echo "<td align = 'center'>".$rowvalid['zipcode']."</td>";
			echo "<td align = 'center'>".$rowvalid['first_name']."</td>";
			echo "<td align = 'center'>".$rowvalid['last_name']."</td>";
			echo "</tr>";
			
			
		}
		
		$resultvalidtoo =mysqli_query($con,"SELECT timestamps,phone,rfirstname,rlastname,ProgramOfInterest,ZipCode, FROM callhistory WHERE `timestamps` > '2012-09-02 00:00:00' AND `timestamps` < '2012-09-09 00:00:00' GROUP BY `phone` order by timestamps desc");
   while($rowvalidtoo = mysqli_fetch_array($resultvalidtoo))
		{
			$getcode =mysqli_query($con,"SELECT * FROM programms WHERE program = '".$rowvalidtoo['ProgramOfInterest']."'");
			$getboundcode = mysqli_fetch_array($getcode);
			$zipresult = mysqli_query($con,"SELECT * FROM mfpzip WHERE zip = '".$rowvalidtoo['zipcode']."'");
            $ziprow = mysqli_num_rows($zipresult);
			$transstat = str_replace("","='", $rowvalidtoo['trans_stat']);
			$transstat = stripslashes($transstat);
			$transstat = mysqli_real_escape_string($con,$transstat);
			
			
			
			echo "<tr>";
			echo "<td align = 'center'>".$rowvalidtoo['phone']."</td>";
			echo "<td align = 'center'>".$getboundcode['program']."</td>";
			echo "<td align = 'center'>".$getboundcode['category']."</td>";			
			echo "<td align = 'center'>".$rowvalidtoo['ZipCode']."</td>";
			echo "<td align = 'center'>".$rowvalidtoo['rfirstname']."</td>";
			echo "<td align = 'center'>".$rowvalidtoo['rlastname']."</td>";
			echo "</tr>";
			
		}


?>
   
   
</table>




</body>
</html>