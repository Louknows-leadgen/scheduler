<?php
session_start();
if(!isset($_SESSION['Username'])){
header("location:index.php");
}


?>
<html>
<head>
<title>Digital Connection I.T. Services</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>.
<link rel="shortcut icon" href="http://payroll.digicononline.com/payslip/favicon.ico" >
   
<!-- Beginning of compulsory code below -->

<link href="css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<link href="viewpayslip.css" media="screen" rel="stylesheet" type="text/css" />

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
			<img src="images/vectorbpo_01.jpg" width="126" height="97" alt=""></td>
		<td>
			<img src="images/vectorbpo_02.jpg" width="826" height="97" alt=""></td>
		<td>
			<img src="images/vectorbpo_03.jpg" width="148" height="97" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/vectorbpo_04.jpg" width="126" height="121" alt=""></td>
		<td>
			<img src="images/vectorbpo_05.jpg" width="826" height="121" alt=""></td>
		<td>
			<img src="images/vectorbpo_06.jpg" width="148" height="121" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/vectorbpo_07.jpg" width="126" height="10" alt=""></td>
		<td>
			<img src="images/vectorbpo_08.jpg" width="826" height="10" alt=""></td>
		<td>
			<img src="images/vectorbpo_09.jpg" width="148" height="10" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/vectorbpo_10.jpg" width="126" height="33" alt=""></td>
		<td background="images/vectorbpo_11.jpg">
		<div style="float:left" >
        	<ul id="nav" class="dropdown dropdown-horizontal">
	<li><a href="vector.php">Home</a></li>
    	<li><a href="viewpayslip.php" target="iframe1">View Payslip</a>
	</li> 
    <li><a href="selectagent.php" target="iframe1">View Sched</a></li>
    
    <li><a href="selectagenthours.php" target="iframe1">View Hours</a></li>
    	
	</li> 
    <?php if($_SESSION['Level'] == '5')
	 {?>
    <li><a href="AddUser.php" target="iframe1">Add User</a>
    <?php
	 }
	?>
	<li><a href="changepassword.php" target="iframe1">Change Password</a>
	</li>    
</ul>
</div>
<div style="float:right; padding-right:30px; font: bold 12px Arial, Helvetica, sans-serif; padding: 5px 12px; background-color: #bb1c23; border-radius: 5px; color: #fff;">
<a style="color: #fff; text-decoration: none;" href="logout.php">Logout</a>
</div>
            </td>
		<td>
			<img src="images/vectorbpo_12.jpg" width="148" height="33" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/vectorbpo_13.jpg" width="126" height="8" alt=""></td>
		<td>
			<img src="images/vectorbpo_14.jpg" width="826" height="8" alt=""></td>
		<td>
			<img src="images/vectorbpo_15.jpg" width="148" height="8" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="images/vectorbpo_16.jpg" width="126" height="263" alt=""></td>
		<td style="border-radius: 0 0 25px 25px;" rowspan="3" background="images/vectorbpo_17.jpg" valign="top">
        
        	<!-- start contents !-->

        <iframe name="iframe1" width="820" height="850" frameborder="0" class="style1" > 
        
        </iframe>

            
        	<!-- end contents !-->
        </td>
		<td>
			<img src="images/vectorbpo_18.jpg" width="148" height="158" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/vectorbpo_19.jpg" width="148" height="105" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="images/vectorbpo_20.jpg" width="126" height="600" alt=""></td>
		<td>
			<img src="images/vectorbpo_21.jpg" width="148" height="575" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/vectorbpo_22.jpg" width="826" height="25" alt=""></td>
		<td rowspan="3">
			<img src="images/vectorbpo_23.jpg" width="148" height="101" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="images/vectorbpo_24.jpg" width="126" height="76" alt=""></td>
		<td>
			<img src="images/vectorbpo_25.jpg" width="826" height="27" alt=""></td>
	</tr>
	<tr>
		<td>
			<div id="copyright_lastpage">2017 Digital Connection Global Solution Inc. All rights reserved.</div>
		</td>
	</tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>