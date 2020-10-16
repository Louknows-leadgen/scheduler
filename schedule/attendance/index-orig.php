<?php

	define('ROOT',dirname($_SERVER['SCRIPT_NAME']));
	define('SCRIPT', ROOT . "/js/scripts.js");
	define('STYLES', ROOT . "/css/styles.css");
	
	require('/controllers')

?>

<!DOCTYPE html>
<html>
<head>
	<title>Time In/Out</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo STYLES; ?>">
</head>
<body>

<?php 
	
	include('/views/nav/menu.php');
	include('/views/time_in_out.php');

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="<?php echo SCRIPT;  ?>"></script>
</body>
</html>