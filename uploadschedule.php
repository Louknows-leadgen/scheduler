<?
session_start();
ob_start();
include("db_connect.php");

if($_POST['task']=='upload')
{
	if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
		mysqli_query($con,"TRUNCATE TABLE `uploaded`"); 
		//echo "<h2>Displaying contents:</h2>";
		//readfile($_FILES['filename']['tmp_name']);
	}
	
	ini_set('auto_detect_line_endings', true);
	//Import uploaded file to Database
	$handle = fopen($_FILES['uploadfile']['tmp_name'], "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		//$date=str_replace("/","-",$data[1]);
		//$strdate=explode("-",$date);
		//$newdate=$strdate[2]."-".$strdate[0]."-".$strdate[1];
		$newdate=$data[1];
		$employeeid=$data[0];
		$countemployeeid=strlen($employeeid);
		if($countemployeeid<=6){
			$employeeid="0".$data[0];
			}
		else{
			$employeeid=$data[0];
			}	
		$querycheck=mysqli_query($con,"select * from uploaded where shiftdate='".$data[1]."' and userid='".$employeeid."'");
		//echo $querycheck."<br>";
	if (mysqli_num_rows($querycheck) == 0)
		{
			$import='insert into uploaded(userid,shiftdate,timein,timeout,status) values ("'.$employeeid.'","'.$newdate.'","'.$data[2].'","'.$data[3].'","'.$data[4].'")';
			echo $import."<br>";
			mysqli_query($con,$import) or die(mysqli_connect_error());
		}
	}
	fclose($handle);
}

?>

<form action="" method="post" enctype="multipart/form-data">
<table border="0">
<tr>
	<td>Upload File: </td><td><input type="file" name="uploadfile" /></td>
</tr>
<tr>
	<td></td><td><input type="submit" name="Upload" value="upload" /></td>
</tr>
</table>
<input type="hidden" name="task" value="upload"  />
</form>


<?

ob_end_flush();
?>