<?php
session_start();
if(!isset($_SESSION['Code'])){
  header("location:index.php");
}
include("db_connect.php");

if(isset($_POST['submit'])){
  $result = mysqli_query($con,"SELECT employeeid FROM prlemployeemaster WHERE employeeid='.$_POST[EmployeeID].'");
  $row = mysqli_num_rows($result);
  echo $row." - ";

  if(($row=='1')||(isset($_POST['EmployeeID']) && $_POST['EmployeeID']=='')){
    echo "Invalid Entry, Either EmployeeId already exists or Employee ID empty";
  }else{
    if(isset($_POST['Active']) && $_POST['Active'] != '2'){
      $hourlyrate = $_POST['PeriodRate']*'12'/'261'/'8';
    }else{
      $hourlyrate = '50.00';
    }

    echo $_POST['Year']." - ";
    // $birth = mktime(0,0,0,date("'.$_POST[Month].'"),date("'.$_POST[Day].'"),date("'.$_POST[Year].'"));
    // $bday = date("Y-m-d", $birth);
    $bday = $_POST[Year]."-".$_POST[Month]."-".$_POST[Day];
    echo $bday." - ";
    $insertemplyee="insert into prlemployeemaster (employeeid,site,RFID,
    lastname,
    firstname,
    middlename,
    address1,
    address2, 
    city,
    state,  
    zip,
    country,
    costcenterid,
    position,
    atmnumber,
    taxactnumber,
    ssnumber,
    hdmfnumber,
    phnumber,
    birthdate,
    marital,
    gender,
    taxstatusid,
    payperiodid,
    paytype,
    periodrate,
    hourlyrate,
    employmenttype,
    active,
    nightrate,
    holidaypay,
    overtimepay) values  ('".$_POST['EmployeeID']."','".$_POST['site']."',
    '".$_POST['RFID']."',
    '".$_POST['LastName']."',
    '".$_POST['FirstName']."',
    '".$_POST['MiddleName']."',
    '".$_POST['Address1']."',
    '".$_POST['Address2']."',
    '".$_POST['City']."',
    '".$_POST['State']."',
    '".$_POST['Zip']."',
    '".$_POST['Country']."',
    '".$_POST['CostCenterID']."',
    '".$_POST['Position']."',
    '".$_POST['ATM']."',
    '".$_POST['TAN']."',
    '".$_POST['SSS']."',
    '".$_POST['HDMF']."',
    '".$_POST['PhilHealth']."',
    '$bday',
    '".$_POST['Marital']."',
    '".$_POST['Gender']."',
    '".$_POST['TaxStatusID']."',
    '".$_POST['PayPeriodID']."',
    '".$_POST['PayType']."',
    '".$_POST['PeriodRate']."',
    '$hourlyrate',
    '".$_POST['Employmenttype']."',
    '".$_POST['Active']."',
    '".$_POST['nightrate']."',
    '".$_POST['holidaypay']."',
    '".$_POST['overtimepay']."')";
  
    //echo $insertemplyee;

    mysqli_query($con,$insertemplyee);
    echo "<br><p style='background-color:yellow;font-size:14px; color:black;'><b>". $_POST['EmployeeID'] . " is enrolled.</b></p>";


    foreach($_POST['income'] as $income){
      $getincome = mysqli_query($con,"select * FROM prlothinctable");
      while($rowincome = mysqli_fetch_array($getincome)){
        if($rowincome['othincid']== $income){   
          $employeeid = $_POST['EmployeeID'];
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
            foreach($_POST['PayoutMonth'] as $key => $month){
              if($income==$key){
                $datepayout = $month;       
                break;
              }
            }
          }
        
          $sql="INSERT INTO prlotherincassign (employeeid, othincid, othincdescription, othincdate, taxable, occurance, payout) VALUES ('$employeeid','$othincid','$othincdescription','$datepayout','$taxable','$occurance','$payout')";
        
          if(!mysqli_query($con,$sql)){
            die('Error: ' . mysqli_connect_error());
          } 
        }
      }
    } 
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="stylelog.css" />
</head>
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

<body>
<form action="" method="post">
    <h1 id="enroll_label1">Enroll Employee</h1>
<table id="enroll_emp">
 <tr>
  <td id="infor_one" width="150" height="20">Employee ID:</td>
    <td><input type="text" maxlength="10" size="11" name="EmployeeID">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RFID:&nbsp;<input size="20" type="text" name="RFID" /></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">Last Name:</td>
    <td><input type="Text" maxlength="40" size="45" name="LastName"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">First Name:</td>
    <td><input type="Text" maxlength="40" size="45" name="FirstName"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">Middle Name:</td>
    <td><input type="Text" maxlength="40" size="45" name="MiddleName"></td>
</tr>
  <tr>
    <td id="infor_one" width="150" height="20">Site Assignment:</td>
    <td>
      <select id="ccid" name="site">
            <option value="OKC">LeadGen OKC OITC</option>
            <option value="NY1">DCI Inayawan Building 1</option>
            <option value="NY2">DCI Inayawan Building 2</option>        
        </select>     </td>
</tr>
  
  
<tr>
<td id="infor_one" width="150" height="20">Address:</td>
<td><input type="Text" maxlength="40" size="45" name="Address1"></td>
</tr>
<tr>
  <td></td>
    <td><input type="Text" maxlength="40" size="45" name="Address2"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">City:</td>
    <td><input type="Text" maxlength="40" size="45" name="City"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">Province:</td>
    <td><input type="Text" maxlength="20" size="45" name="State"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">Zip Code:</td>
    <td><input type="Text" maxlength="15" size="45" name="Zip"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">Country:</td>
    <td><input type="Text" maxlength="40" size="45" name="Country"></td>
</tr>
<tr>
    <td id="infor_one" width="150" height="20">Cost Center:</td>
    <td>
      <select id="ccid" name="CostCenterID">
            <option value="MGT">Management</option>
            <option value="SPV">Supervisor</option>
            <option value="IT">Information Technology</option>
            <option value="FCL">Facilities</option>
            <option value="MAR">Marketing</option>
            <option value="QA">Quality Control</option>
            <option value="AGT">Agent</option>
            <option value="WFM">Work Force Management</option>
            <option value="HC">Human Capital</option>
            <option value="REC">Recruiting</option>
            <option value="TRNG">Training</option>
            <option value="FNA">Finance/Accounting</option>     
            <option value="FLT">Floating</option>          
        </select>     </td>
</tr>
<tr>
    <td id="infor_one" width="150" height="20">Position:</td>
    <td><input type="Text" maxlength="40" size="45" name="Position"></td>
</tr>
<tr>
    <td id="infor_one" width="150" height="20">ATM Number:</td>
  <td><input type="Text" maxlength="20" size="45" name="ATM"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">Tax Account #:</td>
    <td><input type="Text" maxlength="20" size="45" name="TAN"></td>
</tr>
<tr>
  <td id="infor_one" width="150" height="20">SSS #:</td>
    <td><input type="Text" maxlength="20" size="45" name="SSS"></td>
</tr>
<tr>
    <td id="infor_one" width="150" height="20">Pag-ibig #:</td>
    <td><input type="Text" maxlength="20" size="45" name="HDMF"></td>
</tr>
<tr>
    <td id="infor_one" width="150" height="20">PhilHealth #:</td>
    <td><input type="Text" maxlength="20" size="45" name="PhilHealth"></td>
</tr>
<tr> 
            <td id="infor_one" width="150" height="20">Date of Birth:</td>
              <td height="20"> 
                <select id="ccid2" name="Month">
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
              <select id="ccid2" name="Day">
                <option selected="" value="00">Day</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select>
              <select id="ccid2" name="Year">
          <option selected="" value="0000">Year</option>
          <option value="1967">1967</option>
          <option value="1968">1968</option>
          <option value="1969">1969</option>
          <option value="1970">1970</option>
          <option value="1971">1971</option>
          <option value="1972">1972</option>
          <option value="1973">1973</option>
          <option value="1974">1974</option>
          <option value="1975">1975</option>
          <option value="1976">1976</option>
          <option value="1977">1977</option>
          <option value="1978">1978</option>
          <option value="1979">1979</option>
          <option value="1980">1980</option>
          <option value="1981">1981</option>
          <option value="1982">1982</option>
          <option value="1983">1983</option>
          <option value="1984">1984</option>
          <option value="1985">1985</option>
          <option value="1986">1986</option>
          <option value="1987">1987</option>
          <option value="1988">1988</option>
          <option value="1989">1989</option>
          <option value="1990">1990</option>
          <option value="1991">1991</option>
          <option value="1992">1992</option>
          <option value="1993">1993</option>
          <option value="1994">1994</option>
          <option value="1995">1995</option>
          <option value="1996">1996</option>
          <option value="1997">1997</option>
          <option value="1998">1998</option>
          <option value="1999">1999</option>
          <option value="2000">2000</option>
          <option value="2001">2001</option>
          <option value="2002">2002</option>
          <option value="2003">2003</option>
          <option value="2004">2004</option>
          <option value="2005">2005</option>
          <option value="2006">2006</option>
          <option value="2007">2007</option>
          <option value="2008">2008</option>
          <option value="2009">2009</option>
          <option value="2010">2010</option>
          <option value="2010">2011</option>
          <option value="2010">2012</option>
          <option value="2010">2013</option>
          <option value="2010">2014</option>
          <option value="2010">2015</option>
          <option value="2010">2016</option>
          <option value="2010">2017</option>
          <option value="2010">2018</option>
          <option value="2010">2019</option>
          <option value="2010">2020</option>
              </select>                            </td>
          </tr>
                <tr> 
            <td id="infor_one"  width="150">Marital Status :</td>
            <td> 
              <select id="ccid" name="Marital">
                <option value="" selected=""> Select One </option>
                <option value="Single"> Single </option>
                <option value="Married"> Married </option>
                <option value="Sep/Div"> Separated/Divorced </option>
                <option value="Widowed"> Widowed </option>
              </select>            </td>
      </tr>
      <tr> 
      <td id="infor_one" width="150" height="21">Gender :</td>
            <td height="21">
          <input type="radio" name="Gender" value="M" checked="">Male 
          <input type="radio" name="Gender" value="F">Female
      </td>
      </tr>
  <tr>
    <td id="infor_one" width="150" height="20">Tax Status:</td>
    <td>
      <select id="ccid" name="TaxStatusID">
      <?php
          $result = mysqli_query($con,"SELECT taxstatusid, taxstatusdescription from prltaxstatus");
          while($rowgetstatus=mysqli_fetch_array($result))
          {
      ?>
      <option value="<?php echo $rowgetstatus['taxstatusid'];?>"><?php echo $rowgetstatus['taxstatusdescription'];?></option>
 
      <?php         
          }
      ?>    
            </select>
            </td>   
    </tr>
    <tr>
    <td id="infor_one" width="150" height="20">Pay Period:</td>
    <td>
      <select id="ccid" name="PayPeriodID">
        <option value="10">Semi-Monthly</option>
        <option value="20">Monthly</option>
        <option value="30">Weekly</option>
        <option value="40">Bi-Weekly</option>
        <option value="50">Daily</option>
        <option value="60">Quarterly</option>
        <option value="70">Bi-Annual</option>
        <option value="80">Annual</option>
        </select></td>
    </tr>
    <tr>
      <td id="infor_one" width="150" height="20">Pay Type:</td>
        <td>
          <select id="ccid" name="PayType">
              <option value="0">Salary</option>
                <option value="1">Hourly</option>
            </select>        </td>
    </tr>
    <tr>
      <td id="infor_one" width="150" height="20">Monthly Pay/Basic Pay:</td>
    <td><input type="Text" maxlength="12" size="45" name="PeriodRate"></td>
    </tr>
    <tr>
      <td id="infor_one" width="150" height="20">Employment Type:</td>
      <td>
      <select id="ccid" name="Employmenttype">
          <option value="1">Non Exempt</option>
          <option value="0">Exempt</option>       
      </select>
    </td>
    </td>
    </tr>
     <tr>
      <td id="infor_one" width="150" height="20">With Night Differential:</td>
      <td><select id="ccid" name="nightrate">
          <option value="1.10">10% ND </option>
          <option value="1.15">15% ND </option>
          <option value="1.20">20% ND </option>
          <option value="1.25">25% ND </option>
        <option value="0"> None </option>       
      </select></td></td>
    </tr>
    <tr>
      <td id="infor_one" width="150" height="20">With Holiday Pay :</td>
      <td>
      <select id="ccid" name="holidaypay">
          <option value="1"> Yes </option>
          <option value="0"> None </option>
      </select>
    </td>
    </td>
    </tr>
    <tr>
      <td id="infor_one" width="150" height="20">With Overtime Pay :</td>
      <td><select id="ccid" name="overtimepay">
          <option value="1"> Yes </option>
          <option value="0"> None </option>       
      </select></td></td>
    </tr>
   <tr>
    <td id="infor_one" width="150" height="20">Employment Status:</td>
    <td>
      <select id="ccid" name="Active">
          <option value="0">Active</option>
            <option value="1">InActive</option>
            <option value="2">Part-Time</option>

        </select>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
   </table>
  <p>&nbsp;</p>
  <h1 id="enroll_label1">Add Allowance :</h1>
  <table id="enroll_emp2">
    <tr>
      <?php 

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
        <option selected="" value="13">Month</option>
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
  <div id="submit_emp">
    <input id="submit_information" type="submit" value="submit" name="submit" />
  </div>
</form>
</body>
</html>