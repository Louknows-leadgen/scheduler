<?
include("db_connect.php");

if(isset($_POST['todo']) && $_POST['todo']=='15')
{
	$updaterate = $_POST['basicpay']*'12'/'261'/'8';
	$sql = "UPDATE prlemployeemaster SET periodrate = '".$_POST['basicpay']."', hourlyrate = $updaterate, 
	taxstatusid = '".$_POST['taxstatus']."', employmenttype = '".$_POST['employmenttype']."',
	active = '".$_POST['active']."' WHERE employeeid = '".$_POST['employeeid']."'";
    echo $sql;
	mysqli_query($con,$sql);
}

?>