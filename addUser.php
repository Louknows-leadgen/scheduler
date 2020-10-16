<?php
	require '_dbconnection.php';
	extract($_GET);
	$sqlinsert = "insert into paylogin (Username,Password,Level,Name) values ('".$employeeid."','pa\$\$word','1','".$name."')";
	$result = $link->query($sqlinsert);

?>
<link rel="stylesheet" href="//qf.digicononline.com/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//qf.digicononline.com/bower_components/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" href="//qf.digicononline.com/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css"/>
<div class="container-fluid">
	<blockquote>
		<p>The user <?=$name?> has been successfully created.</p>
	</blockqoute>
	<?php
	$sql = "select employeeid, CONCAT_WS(firstname,' ', lastname) as name from prlemployeemaster where not exists (select * from paylogin where paylogin.Username=prlemployeemaster.employeeid)";
	$result = $link->query($sql);
	?>
	<table class="table table-bordered">
		<tr>
			<th>EmployeeId</th>
			<th>Name</th>
			<th>Action</th>
		</tr>
		<?php
		while($row = $result->fetch_assoc()){
		?>
		<tr>
			<td><?=$row['employeeid']?></td>
			<td><?=$row['name']?></td>
			<td><a href="addUser.php?employeeid=<?=$row['employeeid']?>&name=<?=$row['name']?>" target="iframe1" class="btn btn-primary">Create User</a></td>
		</tr>
		<?php } ?>
	</table>
</div>
