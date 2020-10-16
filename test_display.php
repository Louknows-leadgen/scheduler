<?php 

$con = mysqli_connect("localhost","digicono_HRadmin","DigiC0n0nlin3!","internal");
if (!$con){
	die('Could not connect: ' . mysqli_connect_error());
}

$result = mysqli_query($con,"SELECT taxstatusid, percentofexcessamount, fixtax, rangeto from prltaxtablerate GROUP BY percentofexcessamount ORDER BY rangeto ASC");

while($row = mysqli_fetch_array($result)){
	echo $row['taxstatusid'] . "<br>";
}