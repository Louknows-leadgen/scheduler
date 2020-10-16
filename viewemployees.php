<?php
session_start();
if(!isset($_SESSION['Code'])){
header("location:index.php");}
include("db_connect.php");
?>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
img{
border:0;}
-->
</style>
<form action="" method="get">
  <table>
  	<tr>
      	<td><strong>Search</strong></td><td></td>
      </tr>
      <tr>
      	<td>Employee ID</td><td>First Name</td><td>Last Name</td>
      </tr>
      <tr>
      	<td><input type="text" name="employeeid" /></td>
          <td><input type="text" name="firstname" /></td>
          <td><input type="text" name="lastname" /></td>
  	</tr>
  	<tr>
      	<td>Employee Pay Range</td>
  		<td>FROM</td>
  		<td>TO</td>
      </tr>
  	<tr>
      	<td align="right">
          
  		<td><input type="text" name="payfrom" value="8000"/></td>
          <td><input type="text" name="payto" value="10000"/></td>
      </tr>
      <tr>
      	<td colspan="3" align="right">
          (Leave all blank to view all)
          <input type = "hidden" name = "searching" value="1" />
          <input type="submit" name="search" value="Search" /></td>
      </tr>
  </table>
</form>

<?php

if($_POST['todo']=='updateemployeeschedule'){
	$updatescheds="update prlemployeemaster set schedule='".$_POST['groupssched']."' where employeeid='".$_POST['employeeid1']."'";
	//echo $updatescheds;
	mysqli_query($con,$updatescheds);
	echo '<font style="color:#FF3333; size:14px;">Schedule of Employee '.$_POST['employeeid1'].' has been changed!</font>';
	echo "<p>&nbsp;</p>";
}

if($_GET['task']=='1'){
  mysqli_query($con,"DELETE FROM prlemployeemaster WHERE employeeid = '$_GET[employee]'");
  mysqli_query($con,"DELETE FROM prlotherincassign WHERE employeeid = '$_GET[employee]'");
  echo " Deleted!!!";	
}
	 
else if($_GET['task']=='35'){
  if($_GET[Active] != '2'){
    $hourlyrate = $_GET['PeriodRate']*'12'/'261'/'8';}
  else{
    $hourlyrate = '50.00';
  }

	$birth = mktime(0,0,0,date($_GET['Month']),date($_GET['Day']),date($_GET['Year']));
	$bday = date("Y-m-d", $birth);
	mysqli_query($con,"UPDATE prlemployeemaster SET employeeid = '$_GET[NewEmployeeID]',site = '$_GET[site]',
	                                             lastname = '$_GET[LastName]',
												 firstname = '$_GET[FirstName]',
												 middlename = '$_GET[MiddleName]',
												 address1 = '$_GET[Address1]',
												 address2 = '$_GET[Address2]',
												 city = '$_GET[City]',
												 state = '$_GET[State]',
												 zip = '$_GET[Zip]',
												 country = '$_GET[Country]',
												 gender = '$_GET[Gender]',
												 atmnumber = '$_GET[ATM]',
												 ssnumber = '$_GET[SSS]',
												 hdmfnumber = '$_GET[HDMF]',
												 phnumber = '$_GET[PhilHealth]',
												 taxactnumber = '$_GET[TAN]',
												 birthdate = '$bday',
												 periodrate = '$_GET[PeriodRate]',
												 hourlyrate = $hourlyrate,
												 marital = '$_GET[Marital]',
												 taxstatusid = '$_GET[TaxStatusID]',
												 employmenttype = '$_GET[Employmenttype]',
												 active = '$_GET[Active]',
												 costcenterid = '$_GET[CostCenterID]',
												 position = '$_GET[Position]',
												 nightrate = '$_GET[nightrate]',
												 holidaypay = '$_GET[holidaypay]',
												 overtimepay = '$_GET[overtimepay]'
												 WHERE employeeid = '$_GET[EmployeeID]'");
		 
	mysqli_query($con,"DELETE FROM prlotherincassign WHERE employeeid = '$_GET[EmployeeID]'");
	$sqllog = "INSERT INTO prlemplog (Username, ipaddress, description) 
						VALUES ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."',
						'UPDATE ".$_GET[NewEmployeeID].", ".$_GET['LastName'].", ".$_GET['FirstName']." ')";
	mysqli_query($con,$sqllog);
		  
	foreach($_GET['income'] as $income){
    $getincome=mysqli_query($con,"select * FROM prlothinctable");
    while($rowincome=mysqli_fetch_array($getincome)){
      if($rowincome['othincid']== $income){   
        $employeeid = $_GET['EmployeeID'];
        $othincid = $income;
		    $othincdescription = $rowincome['othincdesc'];
		    $payout = $rowincome['payout'];
		    $occurance = $rowincome['occurance'];
        $datepayout = "00";
		    
        if($rowincome['taxable']=='Taxable'){
          $taxable = '1';			 
        }else{
          $taxable = '0';
		    }
		  		  
        if($rowincome['occurance']== 'Optional'){
          foreach($_GET['PayoutMonth'] as $key => $month){
            if($income==$key){
              $datepayout = $month;				
				      break;
		        }
		      }
        }
		  
        $sql="INSERT INTO prlotherincassign (employeeid, othincid, othincdescription, othincdate, taxable, occurance, payout) VALUES ('$employeeid','$othincid','$othincdescription','$datepayout','$taxable','$occurance','$payout')";
	                       
        if (!mysqli_query($con,$sql)){
          die('Error: ' . mysqli_connect_error());
        }	
      }
    }
  }			  

  echo " Updated!!!"; 
}
				
		
else if($_GET['task']=='2'){
  $getemplyees="select * from prlemployeemaster where employeeid='".$_GET['employee']."'";
  $getemplyees=mysqli_query($con,$getemplyees);
  while($rowgetemplyees=mysqli_fetch_array($getemplyees)){ ?>
    <table  border="0" bgcolor="">
      <tr> 
        <td width="200" height="20">Employee ID</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['employeeid']; ?></td>
      </tr>
      <tr> 
        <td width="200" height="20">Site Assignment</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['site']; ?></td>
      </tr>
      <tr> 
        <td width="200" height="20">Lastname</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['lastname']; ?></td>
      </tr>             
      <tr> 
        <td width="200" height="20">Firstname</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['firstname']; ?></td>
      </tr> 
      <tr> 
        <td width="200" height="20">Middlename</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['middlename']; ?></td>
      </tr>  
      <tr> 
        <td width="200" height="20">Address</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['address1']; ?></td>
      </tr>                                    
      <tr> 
        <td width="200" height="20">&nbsp;</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['address2']; ?></td>
      </tr>  
      <tr> 
        <td width="200" height="20">City</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['city']; ?></td>
      </tr> 
      <tr> 
        <td width="200" height="20">Zip Code</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['zip']; ?></td>
      </tr> 
      <tr> 
        <td width="200" height="20">Cost Center</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['costcenterid']; ?></td>
      </tr> 
      <tr> 
        <td width="200" height="20">Position</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['position']; ?></td>
      </tr>     
      <tr> 
        <td width="200" height="20">ATM number</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['atmnumber']; ?></td>
      </tr> 
      <tr> 
        <td width="200" height="20">Tax Account #</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['taxactnumber']; ?></td>
      </tr>  
      <tr> 
        <td width="200" height="20">SSS #</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['ssnumber']; ?></td>
      </tr> 
      <tr> 
        <td width="200" height="20">Pag Ibig #</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['hdmfnumber']; ?></td>
      </tr>
      <tr> 
        <td width="200" height="20">PhilHealth #</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['phnumber']; ?></td>
      </tr>  
      <tr> 
        <td width="200" height="20">Date of Birth</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['birthdate']; ?></td>
      </tr>             <tr> 
        <td width="200" height="20">Marital Status</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['marital']; ?></td>
      </tr>             <tr> 
        <td width="200" height="20">Gender</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['gender']; ?></td>
      </tr>             <tr> 
        <td width="200" height="20">Tax Status</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['taxstatusid']; ?></td>
      </tr>  
      <tr> 
        <td width="200" height="20">Employment Type</td>
        <td width="200" height="20">
          <?php 
              if($rowgetemplyees['employmenttype']=='0'){ echo "Exempt";}
              else if($rowgetemplyees['employmenttype']=='1'){ echo "Non Exempt";} 
          ?>
        </td>
      </tr>   
      <tr> 
        <td width="200" height="20">Night Differential</td>
        <td width="200" height="20">
          <?php 
            if($rowgetemplyees['nightrate']=='0'){ echo "No Night Differential";}
            else if($rowgetemplyees['nightrate']=='1.10'){ echo "10% ND";} 
            else if($rowgetemplyees['nightrate']=='1.15'){ echo "15% ND";}
            else if($rowgetemplyees['nightrate']=='1.20'){ echo "20% ND";}
            else if($rowgetemplyees['nightrate']=='1.25'){ echo "25% ND";}?>
        </td>
      </tr> 
      <tr> 
        <td width="200" height="20">With Holiday Pay</td>
        <td width="200" height="20">
          <?php 
            if($rowgetemplyees['holidaypay']=='0'){ echo "Not Entitled";}
            else if($rowgetemplyees['holidaypay']=='1'){ echo "Entitled";} ?>
        </td>
      </tr> 
      <tr> 
        <td width="200" height="20">With Overtime Pay</td>
        <td width="200" height="20">
          <?php 
            if($rowgetemplyees['overtimepay']=='0'){ echo "Not Entitled";}
            else if($rowgetemplyees['overtimepay']=='1'){ echo "Entitled";} 
          ?>
        </td>
      </tr>                     
      <tr> 
        <td width="200" height="20">Pay Period</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['payperiodid']; ?></td>
      </tr>
      <tr> 
        <td width="200" height="20">Pay Type</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['paytype']; ?></td>
      </tr>
      <tr> 
        <td width="200" height="20">Basic Income</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['periodrate']; ?></td>
      </tr>
      <tr> 
        <td width="200" height="20">Pay per Hour</td>
        <td width="200" height="20"><?php echo $rowgetemplyees['hourlyrate']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>	
      <tr>
        <td>Assigned Other Income:</td>
      </tr>                                                                                                                               
              
      <?php $check=mysqli_query($con,"select * from prlotherincassign where employeeid='$rowgetemplyees[employeeid]'");

      while($checkincome=mysqli_fetch_array($check)){
?>	

        <tr>
          <td>*<?php echo $checkincome['othincdescription'];?></td>
        </tr>
<?php 
      }
?>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<?php              
	}
	$_GET['employee'] = '';		
}				
	 
else if($_GET['task']=='3'){
  $getemplyees="select * from prlemployeemaster where employeeid='".$_GET['employee']."'";
  $getemplyees=mysqli_query($con,$getemplyees);
  $rowgetemplyees=mysqli_fetch_array($getemplyees)
?>
  <form>
    <table  border="0" bgcolor="">
      <tr>
        <td width="200" height="20">Employee ID:</td>
        <td>
          <input type="text" maxlength="10" size="11" name="NewEmployeeID" value="<?php echo $rowgetemplyees['employeeid']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Site Assignment</td>
        <td>
          <select name="site">
            <option value="OKC">LeadGen OKC OITC</option>
            <option value="NY1">DCI Inayawan Building 1</option>
            <option value="NY2">DCI Inayawan Building 2</option> 
          </select>
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Last Name:</td>
        <td>
          <input type="Text" maxlength="40" size="42" name="LastName" value="<?php echo $rowgetemplyees['lastname']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">First Name:</td>
        <td><input type="Text" maxlength="40" size="42" name="FirstName" value="<?php echo $rowgetemplyees['firstname']; ?>"></td>
      </tr>
      <tr>
        <td width="200" height="20">Middle Name:</td>
        <td>
          <input type="Text" maxlength="40" size="42" name="MiddleName" value="<?php echo $rowgetemplyees['middlename']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Address:</td>
        <td>
          <input type="Text" maxlength="40" size="42" name="Address1" value="<?php echo $rowgetemplyees['address1']; ?>">
        </td>
      </tr>
      <tr>
        <td></td>
        <td><input type="Text" maxlength="40" size="42" name="Address2" value="<?php echo $rowgetemplyees['address2']; ?>"></td>
      </tr>
      <tr>
        <td width="200" height="20">City:</td>
        <td>
          <input type="Text" maxlength="40" size="42" name="City" value="<?php echo $rowgetemplyees['city']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Province:</td>
        <td>
          <input type="Text" maxlength="20" size="22" name="State" value="<?php echo $rowgetemplyees['state']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Zip Code:</td>
        <td>
          <input type="Text" maxlength="15" size="17" name="Zip" value="<?php echo $rowgetemplyees['zip']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Country:</td>
        <td>
          <input type="Text" maxlength="40" size="42" name="Country" value="<?php echo $rowgetemplyees['country']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Cost Center:</td>
        <td>
          <select name="CostCenterID">
            <option value="MGT" <?php if($rowgetemplyees['costcenterid']=='MGT'){ echo 'selected="selected"';} ?>>Management</option>
            <option value="SPV" <?php if($rowgetemplyees['costcenterid']=='SPV'){ echo 'selected="selected"';} ?>>Supervisor</option>
            <option value="IT" <?php if($rowgetemplyees['costcenterid']=='IT'){ echo 'selected="selected"';} ?>>Information Technology</option>
            <option value="FCL" <?php if($rowgetemplyees['costcenterid']=='FCL'){ echo 'selected="selected"';} ?>>Facilities</option>
            <option value="MAR" <?php if($rowgetemplyees['costcenterid']=='MAR'){ echo 'selected="selected"';} ?>>Marketing</option>
            <option value="QA" <?php if($rowgetemplyees['costcenterid']=='QA'){ echo 'selected="selected"';} ?>>Quality Control</option>
            <option value="AGT" <?php if($rowgetemplyees['costcenterid']=='AGT'){ echo 'selected="selected"';} ?>>Agent</option>
            <option value="WFM" <?php if($rowgetemplyees['costcenterid']=='WFM'){ echo 'selected="selected"';} ?>>Work Force Management</option>
            <option value="HC" <?php if($rowgetemplyees['costcenterid']=='HC'){ echo 'selected="selected"';} ?>>Human Capital</option>
            <option value="REC" <?php if($rowgetemplyees['costcenterid']=='REC'){ echo 'selected="selected"';} ?>>Recruiting</option>
            <option value="TRNG" <?php if($rowgetemplyees['costcenterid']=='TRNG'){ echo 'selected="selected"';} ?>>Training</option>
            <option value="FNA" <?php if($rowgetemplyees['costcenterid']=='FNA'){ echo 'selected="selected"';} ?>>Finance/Accounting</option>
            <option value="FLT" <?php if($rowgetemplyees['costcenterid']=='FLT'){ echo 'selected="selected"';} ?>>Floating</option>
          </select>
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Position:</td>
        <td>
          <input type="Text" maxlength="40" size="42" name="Position" value="<?php echo $rowgetemplyees['position']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">ATM Number:</td>
        <td>
          <input type="Text" maxlength="20" size="22" name="ATM" value="<?php echo $rowgetemplyees['atmnumber']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Tax Account #:</td>
        <td>
          <input type="Text" maxlength="20" size="22" name="TAN" value="<?php echo $rowgetemplyees['taxactnumber']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">SSS #:</td>
        <td>
          <input type="Text" maxlength="20" size="22" name="SSS" value="<?php echo $rowgetemplyees['ssnumber']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Pag-ibig #:</td>
        <td>
          <input type="Text" maxlength="20" size="22" name="HDMF"  value="<?php echo $rowgetemplyees['hdmfnumber']; ?>">
        </td>
      </tr>
      <tr>
        <td width="200" height="20">PhilHealth #:</td>
        <td>
          <input type="Text" maxlength="20" size="22" name="PhilHealth" value="<?php echo $rowgetemplyees['phnumber']; ?>">
        </td>
      </tr>
      <tr> 
        <td width="200" height="20"> 
              Date of Birth :
        </td>
        <td height="20"> 
          <?php
			       $bday=explode("-",$rowgetemplyees['birthdate']);
          ?>
          <select name="Month">
            <option value="00">Month</option>
            <option value="01" <?php if($bday[1]=='01'){ echo 'selected="selected"';} ?>>January</option>
            <option value="02" <?php if($bday[1]=='02'){ echo 'selected="selected"';} ?>>February</option>
            <option value="03" <?php if($bday[1]=='03'){ echo 'selected="selected"';} ?>>March</option>
            <option value="04" <?php if($bday[1]=='04'){ echo 'selected="selected"';} ?>>April</option>
            <option value="05" <?php if($bday[1]=='05'){ echo 'selected="selected"';} ?>>May</option>
            <option value="06" <?php if($bday[1]=='06'){ echo 'selected="selected"';} ?>>June</option>
            <option value="07" <?php if($bday[1]=='07'){ echo 'selected="selected"';} ?>>July</option>
            <option value="08" <?php if($bday[1]=='08'){ echo 'selected="selected"';} ?>>August</option>
            <option value="09" <?php if($bday[1]=='09'){ echo 'selected="selected"';} ?>>September</option>
            <option value="10" <?php if($bday[1]=='10'){ echo 'selected="selected"';} ?>>October</option>
            <option value="11" <?php if($bday[1]=='11'){ echo 'selected="selected"';} ?>>November</option>
            <option value="12" <?php if($bday[1]=='12'){ echo 'selected="selected"';} ?>>December</option>
          </select>
              
          <select name="Day">
            <option selected="" value="00">Day</option>
            <?php
				      for($day=1;$day<32;$day++){
				        if($day<10){
                  $day="0".$day;
				        }
				    ?>
                <option value="<?php echo $day; ?>"  <?php if($bday[2]==$day){ echo 'selected="selected"';} ?>><?php echo $day; ?></option>
            <?php
				      }
				    ?>
          </select>
              
          <select name="Year">
            <option value="0000">Year</option>
              <?php 
                for($x=1967;$x<=date("Y");$x++){
              ?>
                  <option value="<?php echo $x; ?>"  <?php if($bday[0]==$x){ echo 'selected="selected"';} ?>><?php echo $x; ?></option>
              <?php
                }
              ?>
          </select>
        </td>
      </tr>
		  
      <tr> 
        <td width="200"> 
           Marital Status :
        </td>
        <td> 
          <select name="Marital">
            <option value="" > Select One </option>
            <option value="Single" <?php if($rowgetemplyees['marital']=='Single'){ echo 'selected="selected"';} ?>> Single </option>
            <option value="Married" <?php if($rowgetemplyees['marital']=='Married'){ echo 'selected="selected"';} ?>> Married </option>
            <option value="Sep/Div" <?php if($rowgetemplyees['marital']=='Sep/Div'){ echo 'selected="selected"';} ?>> Separated/Divorced </option>
            <option value="Widowed" <?php if($rowgetemplyees['marital']=='Widowed'){ echo 'selected="selected"';} ?>> Widowed </option>
          </select>
        </td>
      </tr>
      <tr> 
        <td width="200" height="21"> 
          Gender : 
        </td>
        <td height="21"> 
          <input type="radio" name="Gender"  <?php if($rowgetemplyees['gender']=='M'){ echo 'checked="checked"';} ?> value="M"   >
          Male 
          <input type="radio" name="Gender" value="F" <?php if($rowgetemplyees['gender']=='F'){ echo 'checked="checked"';} ?>>
          Female 
        </td>
      </tr>
      
      <tr>
        <td width="200" height="20">Tax Status:</td>
        <td>
          <select name="TaxStatusID">
<?php        
            $result = mysqli_query($con,"SELECT taxstatusid, taxstatusdescription from prltaxstatus");
            while($rowgetstatus=mysqli_fetch_array($result)){
?>        
              <option value="<?php echo $rowgetstatus['taxstatusid'];?>"  <?php if($rowgetemplyees['taxstatusid']==$rowgetstatus['taxstatusid']){ echo 'selected="selected"';} ?>>
                <?php echo $rowgetstatus['taxstatusdescription'];?>
              </option>

<?php         
            }
?>	            
          </select>
        </td>
      </tr>
    
      <tr>
        <td width="200" height="20">Pay Period:</td>
        <td>
          <select name="PayPeriodID">
            <option value="10" <?php if($rowgetemplyees['payperiodid']=='10'){ echo 'selected="selected"';} ?>>Semi-Monthly</option>
            <option value="20" <?php if($rowgetemplyees['payperiodid']=='20'){ echo 'selected="selected"';} ?>>Monthly</option>
            <option value="30" <?php if($rowgetemplyees['payperiodid']=='30'){ echo 'selected="selected"';} ?>>Weekly</option>
            <option value="40" <?php if($rowgetemplyees['payperiodid']=='40'){ echo 'selected="selected"';} ?>>Bi-Weekly</option>
            <option value="50" <?php if($rowgetemplyees['payperiodid']=='50'){ echo 'selected="selected"';} ?>>Daily</option>
            <option value="60" <?php if($rowgetemplyees['payperiodid']=='60'){ echo 'selected="selected"';} ?>>Quarterly</option>
            <option value="70" <?php if($rowgetemplyees['payperiodid']=='70'){ echo 'selected="selected"';} ?>>Bi-Annual</option>
            <option value="80" <?php if($rowgetemplyees['payperiodid']=='80'){ echo 'selected="selected"';} ?>>Annual</option>
          </select>
        </td>
      </tr>
      
      <tr>
        <td width="200" height="20">Pay Type:</td>
        <td>
        	<select name="PayType">
            <option value="0" <?php if($rowgetemplyees['paytype']=='0'){ echo 'selected="selected"';} ?>>Salary</option>
            <option value="1" <?php if($rowgetemplyees['paytype']=='1'){ echo 'selected="selected"';} ?>>Hourly</option>
          </select>
        </td>
      </tr>
    
      <tr>
        <td width="200" height="20">Basic Income:</td>
        <td>
          <input text="password" maxlength="12" size="14" name="PeriodRate" value="<?php echo $rowgetemplyees['periodrate']; ?>" />
        </td>
      </tr>
      <tr>
        <td width="200" height="20">Pay per Hour:</td>
		    <td><?php echo $rowgetemplyees['hourlyrate']; ?></td>
      </tr>
   
      <tr>
   	    <td width="200" height="20">Employment Status:</td>
        <td>
          <select name="Active">
            <option value="0" <?php if($rowgetemplyees['active']=='0'){ echo 'selected="selected"';} ?>>Active</option>
            <option value="1" <?php if($rowgetemplyees['active']=='1'){ echo 'selected="selected"';} ?>>InActive</option>
            <option value="2" <?php if($rowgetemplyees['active']=='2'){ echo 'selected="selected"';} ?>>Part-Time</option>
          </select>
        </td>
      </tr>
   
      <tr>
        <td width="200" height="20">Employment Type:</td>
        <td>
          <select name="Employmenttype">
            <option value="0" <?php if($rowgetemplyees['employmenttype']=='0'){ echo 'selected="selected"';} ?>>Exempt</option>
            <option value="1" <?php if($rowgetemplyees['employmenttype']=='1'){ echo 'selected="selected"';} ?>>Non Exempt</option>
          </select>
        </td>         
      </tr>
        
      <tr>
        <td height="20">With Night Differential:</td>
        <td>
          <select name="nightrate">
            <option value="1.10" <?php if($rowgetemplyees['nightrate']=='1.10'){ echo 'selected="selected"';} ?>>10% ND </option>
            <option value="1.15" <?php if($rowgetemplyees['nightrate']=='1.15'){ echo 'selected="selected"';} ?>>15% ND </option>
            <option value="1.20" <?php if($rowgetemplyees['nightrate']=='1.20'){ echo 'selected="selected"';} ?>>20% ND </option>
            <option value="1.25" <?php if($rowgetemplyees['nightrate']=='1.25'){ echo 'selected="selected"';} ?>>25% ND </option>
            <option value="0" <?php if($rowgetemplyees['nightrate']=='0'){ echo 'selected="selected"';} ?>> None </option>    	  
          </select>
        </td>
      </tr>
    
      <tr>
        <td height="20">With Holiday Pay :</td>
        <td>
          <select name="holidaypay">
            <option value="1" <?php if($rowgetemplyees['holidaypay']=='1'){ echo 'selected="selected"';} ?>> Yes </option>
            <option value="0" <?php if($rowgetemplyees['holidaypay']=='0'){ echo 'selected="selected"';} ?>> None </option>
          </select>
        </td>
      </tr>
    
      <tr>
        <td height="20">With Overtime Pay :</td>
        <td>
          <select name="overtimepay">
            <option value="1" <?php if($rowgetemplyees['overtimepay']=='1'){ echo 'selected="selected"';} ?>> Yes </option>
            <option value="0" <?php if($rowgetemplyees['overtimepay']=='0'){ echo 'selected="selected"';} ?>> None </option>    	  
          </select>
        </td>
      </tr>
   
<?php
      $incometable=mysqli_query($con,"select * from prlothinctable");
      while($income=mysqli_fetch_array($incometable)){ 
      	$incomeassigned=mysqli_query($con,"select * from prlotherincassign where othincid='$income[othincid]' AND employeeid = '$rowgetemplyees[employeeid]'");
      	$incomedata=mysqli_fetch_array($incomeassigned);
      	$check = mysqli_num_rows($incomeassigned);
	
        if($check == '1'){
          $check='"checked=checked"';
        }else{
          $check = "";
        }
?>	  
        <tr>
          <td colspan = "2">
            <input type="checkbox" name="income[]" value="<?php  echo $income['othincid'];?>" <?php echo $check; ?>>
            <?php 
              echo $income['othincdesc']; 

              if($income['occurance']=='Optional' || $income['payout']=='0'){
            ?>
               <!--  <td> -->
                  <select name="PayoutMonth[<?php echo $income['othincid']?>]">
                    <option value="13">Month</option>
                    <option value="02" <?php if($incomedata['othincdate']=='02'){ echo 'selected="selected"';} ?>>February</option>
                    <option value="03" <?php if($incomedata['othincdate']=='03'){ echo 'selected="selected"';} ?>>March</option>
                    <option value="04" <?php if($incomedata['othincdate']=='04'){ echo 'selected="selected"';} ?>>April</option>
                    <option value="05" <?php if($incomedata['othincdate']=='05'){ echo 'selected="selected"';} ?>>May</option>
                    <option value="06" <?php if($incomedata['othincdate']=='06'){ echo 'selected="selected"';} ?>>June</option>
                    <option value="07" <?php if($incomedata['othincdate']=='07'){ echo 'selected="selected"';} ?>>July</option>
                    <option value="08" <?php if($incomedata['othincdate']=='08'){ echo 'selected="selected"';} ?>>August</option>
                    <option value="09" <?php if($incomedata['othincdate']=='09'){ echo 'selected="selected"';} ?>>September</option>
                    <option value="10" <?php if($incomedata['othincdate']=='10'){ echo 'selected="selected"';} ?>>October</option>
                    <option value="11" <?php if($incomedata['othincdate']=='11'){ echo 'selected="selected"';} ?>>November</option>
                    <option value="12" <?php if($incomedata['othincdate']=='12'){ echo 'selected="selected"';} ?>>December</option>
                  </select>     
                <!-- </td> -->
            <?php 
              }
            ?>			   
          </td>
        </tr>
<?php
      }
?>
      <tr>
        <td><input type="hidden" maxlength="10" size="11" name="EmployeeID" value="<?php echo $rowgetemplyees['employeeid']; ?>"></td>
   	    <td><input type = "hidden" name = "task" value = "35"></td>
        <td><input type="submit" value="submit" name="submit" /></td>
      </tr>
    </table>
  </form>
   
<?php
  $_GET['employee'] = '';
}				
?>

<?php
  if($_GET['searching']=='1'){    
?>
    <table border="1" cellpadding="5">
      <tr align="center">
        <td><strong>Emplyee ID</strong></td>
        <td><strong>Site</strong></td>
        <td><strong>Last Name</strong></td>
        <td><strong>First Name</strong></td>
        <td><strong>Basic Pay</strong></td>
        <td><strong>Allowances</strong></td>
        <td><strong>Schedule(24H)</strong></td>
        <td><strong>View</strong></td>
        <td><strong>Edit</strong></td>
      </tr>
<?php
      $getemplyees = mysqli_query($con,"select * from prlemployeemaster WHERE employeeid LIKE '%".$_GET['employeeid']."%' and lastname LIKE '%".$_GET['lastname']."%'  and firstname LIKE '%".$_GET['firstname']."%' AND periodrate >= '".$_GET['payfrom']."' AND periodrate <= '".$_GET['payto']."' AND active = '0' ORDER BY lastname asc");

      $row='0';
      while($rowgetemplyees=mysqli_fetch_array($getemplyees)){
        $row = $row + '1';
?>

        <tr>
          <td><?php echo $rowgetemplyees['employeeid'];?></td>
          <td><?php echo $rowgetemplyees['site'];?></td>
          <td><?php echo $rowgetemplyees['lastname'];?></td>
          <td><?php echo $rowgetemplyees['firstname'];?></td>
          <td><?php echo $rowgetemplyees['periodrate'];?></td>
          <td>
            <?php
            	 /**Getting Allowances**/
            	
            	$otherinc =mysqli_query($con,"SELECT * from prlotherincassign WHERE employeeid = '".$rowgetemplyees['employeeid']."'");
            	while($otherincdata = mysqli_fetch_array($otherinc)){  
                $otherincamt =mysqli_query($con,"SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
                $amt = mysqli_fetch_array($otherincamt); 
                $amount = $amt['othincvalue'];
                echo "**".$otherincdata['othincdescription']." - ".$amount;
            ?>
            	</br>

            <?php			
            	}
            	/**End of Getting Allowances**/
            ?>
          </td>
	
          <td>    
            <form method="post" name="groupschedform.<?php echo $xsub; ?>">
              <select name="groupssched" onChange="this.form.submit()">
                <?php
                  $getgroupsched=mysqli_query($con,"SELECT * FROM groupschedule ORDER BY groupschedulename asc");
     
                  while($rowsched=mysqli_fetch_array($getgroupsched)){
                ?>
                    <option value = "<?php echo $rowsched['groupschedulename']; ?>"<?php if($rowsched['groupschedulename']==$rowgetemplyees['schedule']){ echo 'selected="selected"'; } ?> ><?php echo $rowsched['groupschedulename']; ?> (<?php echo $rowsched['starttime']; ?>-<?php echo $rowsched['endtime']; ?>)</option>
                <?php
                  }
                ?>
                <input type="hidden" name="employeeid1" value="<?php echo $rowgetemplyees['employeeid']; ?>" />
                <input type="hidden" name="todo" value="updateemployeeschedule" />
              </select>
            </form>
          </td>
    
          <td align="center"><a href="?task=2&&employee=<?php echo $rowgetemplyees['employeeid']; ?>" alt="View" name="View"><img src="images/zoom.png" width="20" /></a></td>
          <td align="center"><a href="?task=3&&employee=<?php echo $rowgetemplyees['employeeid']; ?>" alt="Edit"  name="Edit"><img src="images/document_edit.png" width="20"  /></a></td>
        </tr>	 	 	
<?php 
      } //closing for while query
?>
    </table>
<?php
  } //closing for " if searching ==1"
?>

