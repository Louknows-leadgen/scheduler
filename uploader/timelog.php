<?php 
require "settings.php";

if(!empty($_FILES)){
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	extract($_POST);
	if(($handle = fopen($_FILES['dataToUPload']['tmp_name'],"r")) !== FALSE){
		$label=true;
		ob_start();
		$fields = fgetcsv($handle, 1000, ",");
		while($fields = fgetcsv($handle, 1000, ",")){
			echo "<pre>";
			print_r($fields);
			echo "</pre>";
			$datecheck = $link->query("select * from timelog where userid='".$fields[3]."' and dates='".$fields[0]."'");
			echo $datecheck->num_rows;
			if($datecheck->num_rows){
				$existrow = $datecheck->fetch_assoc();
				//echo "updating..<pre>".print_r($existrow)."</pre>";
				echo "update timelog set `startshift`='".$fields[9]."',`endshift`='".$fields[10]."',`status`='".$fields[2]."' where id='".$existrow['id']."'";
				$update = $link->query("update timelog set `startshift`='".$fields[9]."',`endshift`='".$fields[10]."',`status`='".$fields[2]."' where id='".$existrow['id']."'");
			}else{
				//echo "not found..";
				if($fields[3] != ''){
					$query  = "insert ignore into timelog (`dates`, `shiftday`, `status`, `userid`, `skedin`, `skedout`, `timein`, `timeout`, `earlytimedate`, `startshift`, `endshift`, `otstart`, `otend`) values ('".$fields[0]."','".$fields[1]."','".$fields[2]."','".$fields[3]."','".$fields[4]."','".$fields[5]."','".$fields[6]."','".$fields[7]."','".$fields[8]."','".$fields[9]."','".$fields[10]."','".$fields[11]."','".$fields[12]."' );";
					$add = $link->query($query);
				}
			}
		}
	}
}else{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<title>Call History</title>
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	</head>
	<body>
	<?php

		if(empty($_FILES)){

			?>

			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h3>History Upload:</h3>
						<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-xs-3 text-right">Upload CSV file:</label>
								<div class="col-xs-5">
									<input type="file" name="dataToUPload" class="form-control" />
								</div>
							</div>
							<input type="submit" value="Submit" class="btn btn-success"/>
						</form>
					</div>
				</div>
			</div>

		<?php
		}
		?>
	</body>
</html>
<?php 
}

?>