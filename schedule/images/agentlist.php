<?
include('db_connect.php');
print_r($_POST['totransfer']);
if($_POST['submit']){
	$transferthis=$_POST['totransfer'];
foreach($transferthis as $t){
	echo $t.'<br />';
	mysql_query("insert into teamassignment (teamlead,employeeid) values ('".$_POST['TL']."','".$t."')");
	}
}
echo $_POST['TL'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/jquery.editinplace.js"></script>
<script src="js/jquery.js" type="text/javascript"></script>
 <script type="text/javascript">
  $().ready(function() {
   $('#add').click(function() {
						//document.agentlistform.submit();
						//	$('#agentlistform').submit();
    return !$('#select1 option:selected').remove().appendTo('#select2');
	
	
	
   });
   $('#remove').click(function() {
    return !$('#select2 option:selected').remove().appendTo('#select1');
   });
   document.agentlistform.submit();
  });
 </script>
 
 <style type="text/css">
  a {
   display: block;
   border: 1px solid #aaa;
   text-decoration: none;
   background-color: #fafafa;
   color: #123456;
   margin: 2px;
   clear:both;
  }
  div {
   float:left;
   text-align: center;
   margin: 10px;
  }
  
 body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
</style>
</head>

<body>
<!--
<table>
<tr>
	<td>Employee ID</td>
    <td>First Name</td>
    <td>Last Name</td>
</tr>
<?
$getemployee=mysql_query("select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster,teamassignment where costcenterid='AGT' and teamassignment.emplyeeid!=prlemployeemaster.employeeid group by prlemployeemaster.employeeid");
while($rowemployee=mysql_fetch_array($getemployee)){
?>
	 	
<tr>
	<td><?=$rowemployee['employeeid']?></td>
    <td><?=$rowemployee['firstname']?></td>
    <td><?=$rowemployee['lastname']?></td>
</tr>
<?
}
?>

</table>

!-->
<form method="post" name="agentlistform" id="agentlistform">
Select Supervisor: <select name="TL" id="TL" style="height:auto;" >
<?
$getlist=mysql_query("select * from team_supervisor");
while($rowlist=mysql_fetch_array($getlist))
{
?>
<option value="<?=$rowlist['id']?>"><?=$rowlist['TeamSupervisor']?></option>
<?
}
?>
</select>
<br />
<br />


 <div>
  <select multiple id="select1" style="width:300px;height:400px;">
  <?
$getemployee=mysql_query("select prlemployeemaster.employeeid,prlemployeemaster.RFID,prlemployeemaster.lastname,prlemployeemaster.firstname from prlemployeemaster where costcenterid='AGT' group by prlemployeemaster.employeeid");
while($rowemployee=mysql_fetch_array($getemployee)){
?>
   <option value="<?=$rowemployee['employeeid']?>"><?=$rowemployee['employeeid']?> - <?=$rowemployee['firstname']?> <?=$rowemployee['lastname']?></option>
  <?
}
  ?>
   
  </select>
  <a href="#" id="add" onclick="document.agentlistform.submit();">add &gt;&gt;</a>
 </div>
 <div>
  <select multiple id="select2" name="totransfer[]" style="width:300px;height:400px;" ></select>
  <a href="#" id="remove">&lt;&lt; remove</a>
  
 </div>
 <br />
 <br />
<input type="submit" name="submit" value="submit" />
</form>
</body>
</html>