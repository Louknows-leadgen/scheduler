<?php

	require '_dbconnection.php';
	extract($_GET);

	$sql = "DELETE from approved_payperiods where payperiod='".$payperiod."' and employeeid='".$employeeid."'";

	$result = $link->query($sql);

?>