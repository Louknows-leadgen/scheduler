<?
session_start();
include('db_connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >
<title>Agent Select</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
<STYLE>
<!--
  tr { background-color: #DDDDDD}
  .initial { background-color: #DDDDDD; color:#000000 }
  .normal { background-color: #CCCCCC }
  .highlight { background-color: #8888FF }
//-->
</style>

</head>

<body>

<?
$teamleadid=$_SESSION['employeeid'];
//echo $teamleadid;
$gettl=mysql_query("select * from team_supervisor where employeeid='".$teamleadid."'");
while($rowtl=mysql_fetch_array($gettl)){
	echo "<b><font size='6'>".$rowtl['TeamSupervisor']."'s Team</font><b><br><br>";
	}
	
	if($_POST['month']=='')
	{
	$monthtoday=date('m');	
	}
	else{
		$monthtoday=$_POST['month'];
		}
		
	if($_POST['year']=='')
	{
	$yeartoday=date('Y');	
	}
	else{
		$yeartoday=$_POST['year'];
		}
		
	if($_POST['payperiod']=='')
	{
	$payperiod='10';	
	}
	else{
		$payperiod=$_POST['payperiod'];
		}	




?>
<form method="post" name="payperioddaw">
<table>
<tr>
<td>Pay Period:</td>
<td>
    	<select name="month" onchange="document.payperioddaw.submit()">
        		<option></option>
            	<option value="01" <? if($monthtoday=='01'){ echo 'selected="selected"';} ?>>January</option>
                <option value="02" <? if($monthtoday=='02'){ echo 'selected="selected"';} ?>>Febuary</option>
                <option value="03" <? if($monthtoday=='03'){ echo 'selected="selected"';} ?>>March</option>
                <option value="04" <? if($monthtoday=='04'){ echo 'selected="selected"';} ?>>April</option>
                <option value="05" <? if($monthtoday=='05'){ echo 'selected="selected"';} ?>>May</option>
                <option value="06" <? if($monthtoday=='06'){ echo 'selected="selected"';} ?>>June</option>
                <option value="07" <? if($monthtoday=='07'){ echo 'selected="selected"';} ?>>July</option>
                <option value="08" <? if($monthtoday=='08'){ echo 'selected="selected"';} ?>>August</option>
                <option value="09" <? if($monthtoday=='09'){ echo 'selected="selected"';} ?>>September</option>
                <option value="10" <? if($monthtoday=='10'){ echo 'selected="selected"';} ?>>October</option>
                <option value="11" <? if($monthtoday=='11'){ echo 'selected="selected"';} ?>>November</option>
                <option value="12" <? if($monthtoday=='12'){ echo 'selected="selected"';} ?>>December</option>
        </select>
      </td>
   			<td>
            
            <select name="payperiod"  onchange="document.payperioddaw.submit()">
            	<option></option>
            	<option value="10" <? if($payperiod=='10'){ echo 'selected="selected"';} ?>>10</option>
                <option value="25" <? if($payperiod=='25'){ echo 'selected="selected"';} ?>>25</option>
            </select>
            </td>
    		<td>
            
            <select name="year"  onchange="document.payperioddaw.submit()">
            	<option></option>
            	<option value="2010" <? if($yeartoday=='2010'){ echo 'selected="selected"';} ?>>2010</option>
                <option value="2011" <? if($yeartoday=='2011'){ echo 'selected="selected"';} ?>>2011</option>
            </select>
        
        </td>

</tr>
</table>
<br />
</form>
<table border="1" cellpadding="5">
<tr bgcolor="#666666">
	<td><strong>Employee ID</strong></td>
    <td><strong>First Name</strong></td>
    <td><strong>Last Name</strong></td>
    <td><strong>Month</strong></td>
    <td><strong>Pay Period</strong></td>
    <td><strong>Year</strong></td>
    <td><strong>View</strong></td>
    <td><strong>Approved?</strong></td>
</tr>
<?


//$getemployee=mysql_query("select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster,teamassignment where prlemployeemaster.costcenterid='AGT' and  prlemployeemaster.employeeid in (select teamassignment.employeeid from teamassignment where teamlead='".$teamleadid."') group by prlemployeemaster.employeeid");
$getemployee="select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,teamassignment.teamlead from prlemployeemaster,teamassignment where teamassignment.employeeid=prlemployeemaster.employeeid and teamassignment.teamlead='".$teamleadid."' group by prlemployeemaster.employeeid";
//echo $getemployee;
$getemployee=mysql_query($getemployee);
$x=0;
$gettotalcount=mysql_num_rows($getemployee);
if($gettotalcount>0)
{
while($rowemployee=mysql_fetch_array($getemployee)){
	if($x%=2)
	{
		$bgcolor="#999999";
	}
	else{
		$bgcolor="white";
	}
?>
	 	
<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" >
	<td><?=$rowemployee['employeeid']?></td>
    <td><?=$rowemployee['firstname']?></td>
    <td><?=$rowemployee['lastname']?></td>
    <script>
    function target_popup(form) {
    window.open('', 'getdate<?=$rowemployee['employeeid']?>', 'width=1280,height=1000,resizeable,scrollbars');
    form.target = 'getdate<?=$rowemployee['employeeid']?>';
	}
	</script>
    <form name="getdate<?=$rowemployee['employeeid']?>" method="post"  action="viewhours.php" onsubmit="target_popup(this)">
    <input type="hidden" name="employeeid" value="<?=$rowemployee['employeeid']?>" />
    <input type="hidden" name="agentname" value="<?=$rowemployee['firstname']?>" />
    <input type="hidden" name="agenltname" value="<?=$rowemployee['lastname']?>" />
   
    <td>
    	<select name="month">
        		<option></option>
            	<option value="01" <? if($monthtoday=='01'){ echo 'selected="selected"';} ?>>January</option>
                <option value="02" <? if($monthtoday=='02'){ echo 'selected="selected"';} ?>>Febuary</option>
                <option value="03" <? if($monthtoday=='03'){ echo 'selected="selected"';} ?>>March</option>
                <option value="04" <? if($monthtoday=='04'){ echo 'selected="selected"';} ?>>April</option>
                <option value="05" <? if($monthtoday=='05'){ echo 'selected="selected"';} ?>>May</option>
                <option value="06" <? if($monthtoday=='06'){ echo 'selected="selected"';} ?>>June</option>
                <option value="07" <? if($monthtoday=='07'){ echo 'selected="selected"';} ?>>July</option>
                <option value="08" <? if($monthtoday=='08'){ echo 'selected="selected"';} ?>>August</option>
                <option value="09" <? if($monthtoday=='09'){ echo 'selected="selected"';} ?>>September</option>
                <option value="10" <? if($monthtoday=='10'){ echo 'selected="selected"';} ?>>October</option>
                <option value="11" <? if($monthtoday=='11'){ echo 'selected="selected"';} ?>>November</option>
                <option value="12" <? if($monthtoday=='12'){ echo 'selected="selected"';} ?>>December</option>
            </select>
            </td>
   			<td>
            
            <select name="payperiod">
            	<option></option>
            	<option value="10" <? if($payperiod=='10'){ echo 'selected="selected"';} ?>>10</option>
                <option value="25" <? if($payperiod=='25'){ echo 'selected="selected"';} ?>>25</option>
            </select>
            </td>
    		<td>
            
            <select name="year">
            	<option></option>
            	<option value="2010" <? if($yeartoday=='2010'){ echo 'selected="selected"';} ?>>2010</option>
                <option value="2011" <? if($yeartoday=='2011'){ echo 'selected="selected"';} ?>>2011</option>
            </select>
        
        </td>
       <td> <input type="image" src="images/zoom.png"></td>
       <td>
       <?
	   $paydates=$yeartoday."-".$monthtoday."-".$payperiod;
       $checkapprove=mysql_query("select * from approved_payperiods where payperiod='".$paydates."' and employeeid='".$rowemployee['employeeid']."' and TLapproved='1'");
	   $numapprove=mysql_num_rows($checkapprove);
	   if($numapprove>='1'){
       ?>
	   <img src="images/Check-icon2.png" />
       <?
	   }
	   else{
	   ?>
       <img src="images/Delete-icon.png" />
        <? } ?></td>
        </form>
</tr>
<?
$x++;
}
}
else{
	?>
    <tr><td colspan="8" align="center">No data yet</td></tr>
<?
	}
?>
</table>

</body>
</html>