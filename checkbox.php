<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post">
<table>
<?php
if(isset($_POST['submit']))
  {
	foreach($_POST['income'] as $income)
	{
	  echo $income." / "."<br>";
	foreach($_POST['PayoutMonth'] as $key => $month)
	   {
		if($income==$key)
		 {
				 
			    echo $month."<br>";
                break;
		  }
		}
	  }
	}
	
	
   $con = mysqli_connect("localhost","root","qwerty123","VectorBPO");
	if (!$con)
	  {
	  die('Could not connect: ' . mysqli_connect_error());
	  }
	
	// mysql_select_db("VectorBPO", $con);

      $getincome=mysqli_query($con,"select * FROM prlothinctable");
          while($rowincome=mysqli_fetch_array($getincome))
              {
?>
    </tr>
    <tr>
      <td><input type="checkbox" name="income[]" value="<?php  echo $rowincome['othincid'];?>" />
        <?php  echo $rowincome['othincdesc'];?></td>
      <td><?php  echo $rowincome['taxable'];?></td>
      <td><?php  echo $rowincome['occurance'];?></td>
      <td><?php  echo $rowincome['payout'];?></td>
      <?php
			   if($rowincome['occurance']=='Optional' || $rowincome['payout']=='0')
			   {
			   ?>
      <td><select name="PayoutMonth[<?=$rowincome['othincid']?>]">
        <option selected="" value="00">Month</option>
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
      </td>
      <?php 
			   }
			   ?>
    </tr>
    <?php               
			  }
	
?>
  </table>
  <input type="submit" value="submit" name="submit" />
</form>
</body>
</html>