<?
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
//$teamleadid='2';
//$gettl=mysql_query("select * from team_supervisor where id='".$teamleadid."'");
//while($rowtl=mysql_fetch_array($gettl)){
	echo "<b><font size='6'>WFM View Agent Hours</font><b><br><br>";
//	}
?>
<form name="form1" method="get">
Select TL/Supervisor: <select name="tl" onchange="document.form1.submit()">
<option></option>
<?
$getlist=mysql_query("select * from team_supervisor");
while($rowlist=mysql_fetch_array($getlist))
{
?>
 <option value="<?=$rowlist['employeeid']?>" <? if($_GET['tl']==$rowlist['employeeid']){ echo 'selected="selected"';} ?>><?=$rowlist['TeamSupervisor']?></option>
    
<?
}
?>
</select>


<table cellpadding="5">
<tr>
    <td><strong>Month</strong></td>
    <td><strong>Pay Period</strong></td>
    <td><strong>Year</strong></td>
</tr>
<tr>
<td>
    	<select name="month" onchange="document.form1.submit()" >
        		<option></option>
            	<option value="01" <? if($_GET['month']=='01'){ echo 'selected="selected"';} ?>>January</option>
                <option value="02" <? if($_GET['month']=='02'){ echo 'selected="selected"';} ?>>Febuary</option>
                <option value="03" <? if($_GET['month']=='03'){ echo 'selected="selected"';} ?>>March</option>
                <option value="04" <? if($_GET['month']=='04'){ echo 'selected="selected"';} ?>>April</option>
                <option value="05" <? if($_GET['month']=='05'){ echo 'selected="selected"';} ?>>May</option>
                <option value="06" <? if($_GET['month']=='06'){ echo 'selected="selected"';} ?>>June</option>
                <option value="07" <? if($_GET['month']=='07'){ echo 'selected="selected"';} ?>>July</option>
                <option value="08" <? if($_GET['month']=='08'){ echo 'selected="selected"';} ?>>August</option>
                <option value="09" <? if($_GET['month']=='09'){ echo 'selected="selected"';} ?>>September</option>
                <option value="10" <? if($_GET['month']=='10'){ echo 'selected="selected"';} ?>>October</option>
                <option value="11" <? if($_GET['month']=='11'){ echo 'selected="selected"';} ?>>November</option>
                <option value="12" <? if($_GET['month']=='12'){ echo 'selected="selected"';} ?>>December</option>
            </select>
            </td>
   			<td>
            
            <select name="payperiod" onchange="document.form1.submit()">
            	<option></option>
            	<option value="10" <? if($_GET['payperiod']=='10'){ echo 'selected="selected"';} ?>>10</option>
                <option value="25" <? if($_GET['payperiod']=='25'){ echo 'selected="selected"';} ?>>25</option>
            </select>
            </td>
    		<td>
        
            <select name="year" onchange="document.form1.submit()">
            	<option></option>
            	<option value="2010" <? if($_GET['year']=='2010'){ echo 'selected="selected"';} ?>>2010</option>
                <option value="2011" <? if($_GET['year']=='2011'){ echo 'selected="selected"';} ?>>2011</option>
            </select>
        
        </td>
</tr>
</table>
</form><br />
<br />

<table border="1" cellpadding="5">
<tr bgcolor="#666666">
	<td><strong>Employee ID</strong></td>
    <td><strong>First Name</strong></td>
    <td><strong>Last Name</strong></td>
    
    <td><strong>View</strong></td>
</tr>
<?

$monthtoday=date('m');
$yeartoday=date('Y');
$getemployee=mysql_query("select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,prlemployeemaster.schedule from prlemployeemaster,teamassignment where prlemployeemaster.active='0' and  prlemployeemaster.employeeid in  (select teamassignment.employeeid from teamassignment where teamlead='".$_GET['tl']."') group by prlemployeemaster.employeeid");
//echo "select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,prlemployeemaster.schedule from prlemployeemaster,teamassignment where  and prlemployeemaster.active='0' and  prlemployeemaster.employeeid in  (select teamassignment.employeeid from teamassignment where teamlead='".$_GET['tl']."') group by prlemployeemaster.employeeid";
$x=0;
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
    <form name="getdate<?=$rowemployee['employeeid']?>" method="post"  action="wfmviewhours.php" onsubmit="target_popup(this)">
    <input type="hidden" name="employeeid" value="<?=$rowemployee['employeeid']?>" />
    <input type="hidden" name="agentname" value="<?=$rowemployee['firstname']?>" />
    <input type="hidden" name="agenltname" value="<?=$rowemployee['lastname']?>" />
    <input type="hidden" name="month" value="<?=$_GET['month']?>" />
    <input type="hidden" name="payperiod" value="<?=$_GET['payperiod']?>" />
    <input type="hidden" name="year" value="<?=$_GET['year']?>" />
   <td align="center"> 
   <?
   $month=$_GET['month'];
   $payperiod=$_GET['payperiod'];
   $year=$_GET['year']; 
   $thispayperiod=$year."-".$month."-".$payperiod;
   $checkme=mysql_query("select payperiod from approved_payperiods where payperiod='".$thispayperiod."' and employeeid='".$rowemployee['employeeid']."'");
   $numcheckme=mysql_num_rows($checkme);
   if($numcheckme>=1){
?>
   <input type="image" src="images/zoom.png">
   <?
   }
   ?>
   </td>
        </form>
</tr>
<?
$x++;
}
?>
</table>

</body>
</html>