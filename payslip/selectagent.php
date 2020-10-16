<?
session_start();
include('db_connect.php');
//echo $_SESSION['employeeid'];.
$Username=$_SESSION['Username'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico" >
<link href="viewpayslip.css" media="screen" rel="stylesheet" type="text/css" />
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

<body id="body_wrapper">
<div id="border_wrapper">
<div id="header_wrapper">
	<div id="left_header">
		<h1><a href="">Digital Connection Global Solution</a></h1>
	</div>
</div><!---header_wrapper--->
<table id="select_wrapper" cellpadding="5">
<tr bgcolor="#666666">
	<td id="title_header"><strong>Employee ID</strong></td>
    <td id="title_header"><strong>First Name</strong></td>
    <td id="title_header"><strong>Last Name</strong></td>
    <td id="title_header"><strong>Month</strong></td>
    <td id="title_header"><strong>Pay Period</strong></td>
    <td id="title_header"><strong>Year</strong></td>
    <td id="title_header"><strong>View</strong></td>
</tr>
<?
$monthtoday=date('m');
$yeartoday=date('Y');
$getemployee=mysqli_query($con,"select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname,teamassignment.teamlead from prlemployeemaster,teamassignment where teamassignment.employeeid=prlemployeemaster.employeeid and prlemployeemaster.employeeid='".$_SESSION['Username']."' group by prlemployeemaster.employeeid");
//
$x=0;
while($rowemployee=mysqli_fetch_array($getemployee)){
	if($x%=2)
	{
		$bgcolor="#999999";
	}
	else{
		$bgcolor="white";
	}
?>
	 	
<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" >
	<td id="select_content"><?=$rowemployee['employeeid']?></td>
    <td id="select_content"><?=$rowemployee['firstname']?></td>
    <td id="select_content"><?=$rowemployee['lastname']?></td>
    <script>
    function target_popup(form) {
    window.open('', 'getdate<?=$rowemployee['employeeid']?>', 'width=1280,height=1000,resizeable,scrollbars');
    form.target = 'getdate<?=$rowemployee['employeeid']?>';
	}
	</script>
    <form name="getdate<?=$rowemployee['employeeid']?>" method="post"  action="calendar.php" onsubmit="target_popup(this)">
   
   <input type="hidden" name="schedule" value="<?=$rowemployee['schedule']?>" />
    <input type="hidden" name="employeeid" value="<?=$rowemployee['employeeid']?>" />
    <input type="hidden" name="agentname" value="<?=$rowemployee['firstname']?>" />
    <input type="hidden" name="agenltname" value="<?=$rowemployee['lastname']?>" />
    <td id="select_content">
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
   			<td id="select_content">
            
            <select name="payperiod">
            	<option></option>
            	<option value="10">10</option>
                <option value="25">25</option>
            </select>
            </td>
    		<td id="select_content">
            <select name="year">
            	<option></option>
            	<option value="2010" <? if($yeartoday=='2010'){ echo 'selected="selected"';} ?>>2010</option>
                <option value="2011" <? if($yeartoday=='2011'){ echo 'selected="selected"';} ?>>2011</option>
            </select>
        
        </td>
       <td id="select_content"><input type="image" src="images/zoom.png"></td>
        </form>
</tr>
<?
$x++;
}
?>
<tr>
	<td id="ghost_td">test</td>
</tr>
</table>
</div>

</body>
</html>