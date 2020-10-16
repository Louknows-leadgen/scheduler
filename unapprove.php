<?php
	require '_dbconnection.php';
	extract($_GET);
	//$sqlinsert = "insert into paylogin (Username,Password,Level,Name) values ('".$employeeid."','pa\$\$word','1','".$name."')";
	//$result = $link->query($sqlinsert);

?>
<link rel="stylesheet" href="//qf.digicononline.com/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//qf.digicononline.com/bower_components/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" href="//qf.digicononline.com/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css"/>
<div class="container-fluid">
	<!--<blockquote>
		<p>The user <?=$name?> has been successfully created.</p>
	</blockqoute>-->
	<?php
	$sql = "select employeeid, CONCAT_WS(firstname,' ', lastname) as name from prlemployeemaster";
	$result = $link->query($sql);
	?>
	<div class="row">
		<div class="col-md-12">
			<form method="get">
			<div class="form-group">
				<div class="col-sm-3">
				
				<label>Select Payperiod</label>
				</div>
				<div class="col-sm-3">
				<select class="form-control" name="payperiod">
					<option value="--choose one--"></option
					<?php for($i=1;$i<=12;$i++){ ?>
					<option value="<?=date('Y-').($i>9?$i:'0'.$i).'-10'?>"><?=date('Y-').($i>9?$i:'0'.$i).'-10'?></option>
					<option value="<?=date('Y-').($i>9?$i:'0'.$i).'-25'?>"><?=date('Y-').($i>9?$i:'0'.$i).'-25'?></option>
					<?php } ?>
				</select>
				
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default" >Submit</button>
			</div>
			</form>
			<br/><br/><br/><br/>
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
			<td><a href="unapproveUser.php?employeeid=<?=$row['employeeid']?>&payperiod=<?=$payperiod?>" target="iframe1" class="btn btn-primary">Unapprove</a></td>
		</tr>
		<?php } ?>
	</table>
		</div>
	</div>
	
</div>
