<?
include('db_connect.php');
$transferthis=$_POST['totransfer'];
foreach($transferthis as $t){
	echo $t.'<br />';
mysqli_query($con,"insert into teamassignment (teamlead,employeeid) values ('".$_POST['TL']."','".$t."')");
}
	?>