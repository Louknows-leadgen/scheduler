<?php
session_start();
if(!isset($_SESSION['Username'])){
header("location:index.php");
}

//echo $_SESSION['Level'];
?>
<html>
<head>
<title>Digital Connection IT Services</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>.
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >
   
<!-- Beginning of compulsory code below -->

<link href="../css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

<!-- / END -->
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (vectorbpo.psd) -->
<table id="Table_01" width="1100" height="1080" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td>
			<img src="../images/vectorbpo_01.jpg" width="126" height="97" alt=""></td>
		<td>
			<img src="../images/vectorbpo_02.jpg" width="826" height="97" alt=""></td>
		<td>
			<img src="../images/vectorbpo_03.jpg" width="148" height="97" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_04.jpg" width="126" height="121" alt=""></td>
		<td>
			<img src="../images/vectorbpo_05.jpg" width="826" height="121" alt=""></td>
		<td>
			<img src="../images/vectorbpo_06.jpg" width="148" height="121" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_07.jpg" width="126" height="10" alt=""></td>
		<td>
			<img src="../images/vectorbpo_08.jpg" width="826" height="10" alt=""></td>
		<td>
			<img src="../images/vectorbpo_09.jpg" width="148" height="10" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_10.jpg" width="126" height="33" alt=""></td>
		<td background="../images/vectorbpo_11.jpg">
		<div style="float:left" >
        	<ul id="nav" class="dropdown dropdown-horizontal">
    <?php
	if($_SESSION['Level']=='3'){
	?>
<li><a href="" class="dir">Scheduler</a>
		<ul>
			<li><a href="shiftadd.php" target="iframe1">Add Schedule</a></li>
			<li><a href="viewsched.php"  target="iframe1">View/Edit</a></li>
			<li><a href="viewemployees.php" target="iframe1">Assign Schedule</a></li>
			
		</ul>
	</li>
    <li><a href="activateemployees.php" target="iframe1">View Employees</a></li>  
    <li><a href="addSupervisor.php" target="iframe1">Add TL</a></li>  
    <li><a href="agentlist.php" target="iframe1">Assign TL</a></li>       
    <?php
	}
	
    else{
    
    }
	?>
	
	<li><a href="<?php if($_SESSION['Level']=='3') { echo "wfmselectagent.php"; } else{ echo "selectagent.php"; } ?>" target="iframe1">Time Log</a></li>
	<li><a href="<?php if($_SESSION['Level']=='3') { echo "wfmapprovehours.php"; } else{ echo "selectagenthours.php"; } ?>" class="dir" target="iframe1">View Hours</a>
		<!--<ul>
			<li class="empty">Industries</li>
			<li><a href="enrollemplyees.php" target="iframe1">Enroll</a></li>
			<li><a href="viewemployees.php" target="iframe1">View/Edit</a></li>
			<li><a href="viewemployees.php" target="iframe1">Assign Schedule</a></li>
		</ul>!-->
	</li>
	<li><a href="changepassword.php" target="iframe1">Change Password</a></li>
	
</ul>
</div>
<div style="float:right;padding-right:30px; font: bold 12px Arial, Helvetica, sans-serif; padding: 7px 12px; background-color: #a65302; color: #fff;">
<a href="logout.php">LOG out</a>
</div>
            </td>
		<td>
			<img src="../images/vectorbpo_12.jpg" width="148" height="33" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_13.jpg" width="126" height="8" alt=""></td>
		<td>
			<img src="../images/vectorbpo_14.jpg" width="826" height="8" alt=""></td>
		<td>
			<img src="../images/vectorbpo_15.jpg" width="148" height="8" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="../images/vectorbpo_16.jpg" width="126" height="263" alt=""></td>
		<td rowspan="3" background="../images/vectorbpo_17.jpg" valign="top">
        
        	<!-- start contents !-->

        <iframe name="iframe1" width="820" height="800" frameborder="0" class="style1" > 
        
        </iframe>

            
        	<!-- end contents !-->
        </td>
		<td>
			<img src="../images/vectorbpo_18.jpg" width="148" height="158" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_19.jpg" width="148" height="105" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="../images/vectorbpo_20.jpg" width="126" height="600" alt=""></td>
		<td>
			<img src="../images/vectorbpo_21.jpg" width="148" height="575" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_22.jpg" width="826" height="25" alt=""></td>
		<td rowspan="3">
			<img src="../images/vectorbpo_23.jpg" width="148" height="101" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="../images/vectorbpo_24.jpg" width="126" height="76" alt=""></td>
		<td>
			<img src="../images/vectorbpo_25.jpg" width="826" height="27" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../images/vectorbpo_26.jpg" width="826" height="49" alt=""></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>