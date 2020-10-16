<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
img{
border:0;}
-->
</style>
<?php
include("db_connect.php");
if($_POST['shiftname']!='')
{
	$groupschedulename=$_POST['shiftname'];
	$starttime=$_POST['shiftstarthour'].":".$_POST['shiftstartmin'].":00";
	$lunchstarting=$_POST['lunchstarthour'].":".$_POST['lunchstartmin'].":00";
	$lunchhour = $_POST['lunchstarthour'] + 1;
	$lunchending=$lunchhour.":".$_POST['lunchstartmin'].":00";
	$endtime=$_POST['shiftendhour'].":".$_POST['shiftendmin'].":00";
	$prelunch = $_POST['lunchstarthour'] - $_POST['shiftstarthour'] ;
	if($prelunch< 0 )
	{
		$prelunch = $prelunch + 24;
	}
	$prelunchmin = $_POST['lunchstartmin']/60;
	$prelunch = $prelunch.".".$prelunchmin;
	$Mon=$_POST['Mon']; 
	$Tue=$_POST['Tue']; 
	$Wed=$_POST['Wed']; 
	$Thu=$_POST['Thu']; 
	$Fri=$_POST['Fri']; 
	$Sat=$_POST['Sat']; 
	$Sun=$_POST['Sun']; 
	$Holiday=$_POST['Holiday'];
	
	$start=($_POST['shiftstarthour']*3600)+($_POST['shiftstartmin']*60);
	$end=($_POST['shiftendhour']*3600)+($_POST['shiftendmin']*60);
	
	if($start>$end){
		$otherday=1;
		}
	else{
		$otherday=0;
		}
	mysqli_query($con,"insert into groupschedule(groupschedulename,
	starttime,
	endtime, lunchstart, lunchend,prelunch, Mon, Tue, Wed, Thu, Fri, Sat, Sun, Holiday, otherday) values ('$groupschedulename',
	'$starttime',
	'$endtime', '$lunchstarting', '$lunchending', '$prelunch', '$Mon', '$Tue', '$Wed', '$Thu', '$Fri', '$Sat', '$Sun', '$Holiday', '$otherday')");
	$message=$groupschedulename." has been added.";
}
?>
<link rel="stylesheet" type="text/css" href="css/styles.css" />


<font size="14"><?php echo $message; ?></font>
<form action="" method="post">
  <table border="0" bgcolor="#FFFFFF">
  <tr>
  <td colspan="2" class="pagetitle"> ADD Schedule</td>
  </tr>
  <tr>
    <td width="87">Shift Name:</td>
    <td width="417"><input type="text" name="shiftname" /></td>
  </tr>
  <tr>
    <td>Shift Start:</td>
    <td>
    	<select name="shiftstarthour" />
    	<?php
		for($x=0;$x<25;$x++){
		?>
        	<option><?php if($x<10){ echo "0".$x; } else { echo $x; } ?></option>
        <?php
		}
		?>
    	</select>
        <select name="shiftstartmin">
            <option>00</option>
            <option>15</option>
            <option>30</option>
            <option>45</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Lunch Start:</td>
    <td>
    	<select name="lunchstarthour" />
    	<?php
		for($x=0;$x<25;$x++){
		?>
        	<option><?php if($x<10){ echo "0".$x; } else { echo $x; } ?></option>
        <?php
		}
		?>
    	</select>
        <select name="lunchstartmin">
            <option>00</option>
            <option>15</option>
            <option>30</option>
            <option>45</option>
        </select>
    </td>   
  </tr>  
  <tr>
    <td>Shift End:</td>
    <td>
    	<select name="shiftendhour" />
    	<?php
		for($x=0;$x<25;$x++){
		?>
        <option><?php if($x<10){ echo "0".$x; } else { echo $x; } ?></option>
        <?php
		}
		?>
        </select>
        <select name="shiftendmin">
            <option>00</option>
            <option>15</option>
            <option>30</option>
            <option>45</option>
        </select>
    </td>
  </tr>
   <tr>
    <td></td>
    <td>
    	<input type="checkbox" name="Mon" value="1" /> Mon  
    	<input type="checkbox" name="Tue" value="1" /> Tue  
        <input type="checkbox" name="Wed" value="1" /> Wed  
        <input type="checkbox" name="Thu" value="1" /> Thu  
        <input type="checkbox" name="Fri" value="1" /> Fri  
        <input type="checkbox" name="Sat" value="1" /> Sat  
        <input type="checkbox" name="Sun" value="1" /> Sun  
        <input type="checkbox" name="Holiday" value="1" /> Holiday  
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Add Schedule" value="Add Schedule"></td>
  </tr>
 
</table>
</form>