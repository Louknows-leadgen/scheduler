<?php
session_start();
ob_start();

//echo "this ".$_SESSION['test'];
include('db_connect.php');
$pmonth=$_POST['month'];
$ppayperiod=$_POST['payperiod'];
$pyear=$_POST['year']; 
$approve=0;
$checkifapproved=mysql_query("select * from approved_payperiods where payperiod='".$pyear."-".$pmonth."-".$ppayperiod."' and employeeid='".$_POST['employeeid']."'");
$checknum=mysql_num_rows($checkifapproved);
if($checknum>=1){
	$message="This has already been approved";
	$approve='1';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$_POST['employeeid']?> <?=$_GET['employeeid']?> - <?=$_POST['agentname']?> <?=$_POST['agenltname']?> <?=$_GET['agentname']?> <?=$_GET['agenltname']?>'s Schedule</title>
<link rel="shortcut icon" href="../favicon.ico" >
<link rel="icon" type="image/gif" href="../images/animated_favicon1.gif" >
<?
	echo "select * from approved_payperiods where payperiod='".$pyear."-".$pmonth."-".$ppayperiod."' and employeeid='".$_POST['employeeid']."'";
	?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>

<script type="text/javascript" src="js/jquery.ui.js"></script>
<? if($approve!='1'){ ?>
<script type="text/javascript" src="js/jquery.editinplace.js"></script>
<? } ?>
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
</body></html>

