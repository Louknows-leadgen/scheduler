<?php
session_start();
$_SESSION['test']=$_POST['update_value'];
include('db_connect.php');
/*
 * Another In Place Editor - a jQuery edit in place plugin
 *
 * Copyright (c) 2009 Dave Hauenstein
 *
 * License:
 * This source file is subject to the BSD license bundled with this package.
 * Available online: {@link http://www.opensource.org/licenses/bsd-license.php}
 * If you did not receive a copy of the license, and are unable to obtain it,
 * email davehauenstein@gmail.com,
 * and I will send you a copy.
 *
 * Project home:
 * http://code.google.com/p/jquery-in-place-editor/
 *
 */
 
// sleep for a half or a second
// for demonstrating the 'saving...' functionality on the front end
usleep(1000000 * .5);

/*
 * These are the default parameters that get to the server from the in place editor
 *
 * $_POST['update_value']
 * $_POST['element_id']
 * $_POST['original_html']
 *
*/

/*
 * since the in place editor will display whatever the server returns
 * we're just going to echo out what we recieved. In reality, we can 
 * do validation and filtering on this value to determine if it was valid
*/

//echo "<br><br>".$_POST['element_id']."  ". $_POST['update_value'];

if($_POST['update_value']!='') {

	$data=$_POST['element_id'];
	//$data="2010_5_16_1100";
	$stringdata=explode("_",$data);
	$dates=$stringdata[0]."-".$stringdata[1]."-".$stringdata[2];
	
	$strdates=strtotime($dates);
	$shiftday=date("D", $strdates);
	$userid=$stringdata[3];
	$getdata="select * from timelog where userid='".$userid."' and dates='".$dates."'";
	$getdata=mysqli_query($con,$getdata);


	if($stringdata[4]=='editstatus'){
		$status=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$early."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			echo $_POST['update_value'];
			}
		else{
			$update="update timelog set `status`='".$status."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
	}
	
	else if($stringdata[4]=='changeearlydatetime'){
		$earlytimedate=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `earlytimedate`='".$earlytimedate."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
		else if($stringdata[4]=='changestartshift'){
		$startshift=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `startshift`='".$startshift."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
		else if($stringdata[4]=='changeendshift'){
		$endshift=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `endshift`='".$endshift."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
		
		
		
		
		else if($stringdata[4]=='changelunchstart'){
		$startlunch=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`startshift`, `endlunch`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$startlunch."','".$endlunch."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `startlunch`='".$startlunch."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
		else if($stringdata[4]=='changeendlunch'){
		$endlunch=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`startshift`, `endlunch`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$startlunch."','".$endlunch."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `endlunch`='".$endlunch."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
		
		
		else if($stringdata[4]=='changeotstart'){
		$otstart=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `otstart`='".$otstart."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
		else if($stringdata[4]=='changeotend'){
		$otend=$_POST['update_value'];
		if (mysqli_num_rows($getdata) == 0)
			{
				$insert="insert into timelog (`dates`,`shiftday`,`status`,`userid`,`skedin`,`skedout`,`timein`,`timeout`,`earlytimedate`,`startshift`,`endshift`,`otstart`,`otend`)values('".$dates."','".$shiftday."','".$status."','".$userid."','".$startskeddaw."','".$endskeddaw."','".$timein."','".$timeout."','".$earlytimedate."','".$startshift."','".$endshift."','".$otstart."','".$otend."')";	
				//echo $insert;
			mysqli_query($con,$insert);
			
			}
		else{
			$update="update timelog set `otend`='".$otend."' where dates='".$dates."' and userid='".$userid."'";
			//echo $update;
			mysqli_query($con,$update);
			}	
			echo $_POST['update_value'];
		
		}
		
	else if($stringdata[4]=='thisshift'){
		$thisdaysshift=$_POST['update_value'];
		$getsked=mysqli_query($con,"select * from groupschedule where groupschedulename='".$thisdaysshift."'");
		while($rowskeds=mysqli_fetch_array($getsked)){
			$starttime=$rowskeds['starttime'];
			$endtime=$rowskeds['endtime'];
			$otherday=$rowskeds['otherday'];
			}
		$starttimes=$dates." ".$starttime;
		
		$datetomorrow = date('Y-m-d', strtotime($dates) + 86400);
		if($otherday=='1')
		{
			$endtimes=$datetomorrow." ".$endtime;
			}
			
		else{
			$endtimes=$dates." ".$endtime;
			}	
		
		$update="update timelog set `thisdaysshift`='".$thisdaysshift."',`skedin`='".$starttimes."',`skedout`='".$endtimes."' where dates='".$dates."' and userid='".$userid."'";
		//echo $update;
		mysqli_query($con,$update);
				echo $_POST['update_value'];
		}	
		
	else{
		echo $_POST['original_value']; 
		}	
	
	
	

}

//else { 
//	echo $_POST['original_value']; 
//	}