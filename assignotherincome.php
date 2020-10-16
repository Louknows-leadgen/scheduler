<?
include('db_connect.php');
$employeeid=$_POST['employeeid'];
$checkedemployeeid=$_POST['checkemployeeid'];

$x=0;
print_r($checkemployeeid);
echo "<br>";
print_r($employeeid);
foreach($employeeid as $value){
	
	if (in_array($value, $checkedemployeeid)) {
    echo "Got ".$value."<br>";
		}
	else{
		echo "no ".$value."<br>";
		}
	$x++;
	}
?><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
<form method="get" name="selectotherincome">
<select name="otherincome" onchange="document.selectotherincome.submit()">
<option></option>
<?
$getotherincome=mysqli_query($con,"select * from prlothinctable");
while($rowotherincome=mysqli_fetch_array($getotherincome)){
?>
<option value="<?=$rowotherincome['othincid']?>" <? if($rowotherincome['othincid']==$_GET['otherincome']){ echo 'selected="selected"';}?>><?=$rowotherincome['othincdesc']?></option>
<?
}
?>
</select>
</form><br>

<form method="post">
<?
$getemployees=mysqli_query($con,"select employeeid,lastname,firstname from prlemployeemaster");
while($rowemployees=mysqli_fetch_array($getemployees)){
 $checkifregistered=mysqli_query($con,"select employeeid from prlotherincassign where employeeid='".$rowemployees['employeeid']."' and othincid='".$_GET['otherincome']."'");
 if(!$checkifregistered)
 {
	 
	 }
 else{
	 $numregistered=mysqli_num_rows($checkifregistered);
	 
	 }	
if($numregistered=='0')	 
{
	$checked="";
	}
	else{
		$checked='"checked=checked"';
		}
?>

<input type="hidden" name="employeeid[]" value="<?=$rowemployees['employeeid']?>">
<input type="checkbox" name="checkemployeeid[]" value="<?=$rowemployees['employeeid']?>" <?=$checked?>> <?=$rowemployees['firstname']?> <?=$rowemployees['lastname']?><br>

<?
}
?>
<input type="submit" value="submit" name="submit">
</form>

<table>
<tr>
<td></td>
</tr>
</table>

<?


?>