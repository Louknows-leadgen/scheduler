<?php
session_start();
if(!isset($_SESSION['Username'])){
header("location:index.php");
}
?>
<html>
<head>
<title>Digital Connection IT Services</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
  font-family: Verdana, Geneva, sans-serif;
  font-size: 12px;
}
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>.
<link rel="shortcut icon" href="favicon.ico" >
<!-- Beginning of compulsory code below -->
<link href="css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

<!-- / END -->
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (vectorbpo.psd) -->


<table id="Table_01" width="1100" height="1080" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
      <img src="images/vectorbpo_01.jpg" width="126" height="97" alt=""></td>
    <td>
      <img src="images/vectorbpo_02.jpg" width="826" height="97" alt=""></td>
    <td>
      <img src="images/vectorbpo_03.jpg" width="148" height="97" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_04.jpg" width="126" height="121" alt=""></td>
    <td>
      <img src="images/vectorbpo_05.jpg" width="826" height="121" alt=""></td>
    <td>
      <img src="images/vectorbpo_06.jpg" width="148" height="121" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_07.jpg" width="126" height="10" alt=""></td>
    <td>
      <img src="images/vectorbpo_08.jpg" width="826" height="10" alt=""></td>
    <td>
      <img src="images/vectorbpo_09.jpg" width="148" height="10" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_10.jpg" width="126" height="33" alt=""></td>
    <td background="images/vectorbpo_11.jpg">
    <div style="float:left" >
          <ul id="nav" class="dropdown dropdown-horizontal">
  <li><a href="vector.php">Home</a></li>
  <li><a href="" class="dir">Employees</a>
    <ul>
      <!--<li class="empty">Industries</li>!-->
      <li><a href="enrollemplyees.php" target="iframe1">Enroll</a></li>
      <li><a href="viewemployees.php" target="iframe1">View/Edit</a></li>
      <li><a href="viewemployees.php" target="iframe1">Assign Schedule</a></li>
    </ul>
  </li>
  <li><a href="" class="dir">Scheduler</a>
    <ul>
      <li><a href="shiftadd.php" target="iframe1">Add Schedule</a></li>
      <li><a href="viewsched.php"  target="iframe1">View/Edit</a></li>
      <li><a href="viewemployees.php" target="iframe1">Assign Schedule</a></li>
            <li><a href="schedule/viewlogs.php?todo=10" target="_blank">View logs</a></li>
      
    </ul>
  </li>
  <li><a href="" class="dir">Tables</a>
    <ul>
          <!--<li class="empty">Tax</li>!-->
      <li><a href="tax.php?todo=10" target="iframe1">Tax Status</a></li>
            <!--<li class="empty">Overtime</li>!-->
      <li><a href="overtime.php?todo=10" target="iframe1">Overtime Table</a></li>
            <li><a href="holiday.php?todo=10" target="iframe1">Holiday Table</a></li>
      <li><a href="income.php?todo=10" target="iframe1">Other Income Table</a></li>
            <li><a href="leavetable.php?todo=10" target="iframe1">Leave Table</a></li>
      <li><a href="sss.php?todo=10" target="iframe1">SSS Table</a></li>
      <li><a href="philhealth.php?todo=10" target="iframe1">PhilHealth Table</a></li>
      <li><a href="taxtable.php?todo=10" target="iframe1">Tax Table Rate</a></li>
      
    </ul>
  </li>
  <li><a href="" class="dir">User Management</a>
    <ul>
      <!--<li class="empty">By user</li>!-->
      <li><a href="addUser.php" target="iframe1">Add New User</a></li>
      <li><a href="editUser.php">Edit User</a></li>
      <li><a href="">Delete User</a></li>
      
    </ul>
  </li>
  <li><a href="" class="dir">Payroll</a>
    <ul>
      <!--<li class="empty">By user</li>!-->
            <li><a href="createpayperiod.php" target="iframe1">Create Payroll</a></li>
            <li><a href="editpayroll.php?todo=10" target="iframe1">Edit Payroll</a></li>
            <li><a href="payrollreport.php?todo=10" target="iframe1">Payroll Report</a></li>
            <li><a href="ytd.php?todo=10" target="iframe1">YTD Report</a></li>
      <li><a href="">Create Payslip</a></li>
      <li><a href="">View Payslip</a></li>
    </ul>
  </li>
  <li><a href="" class="dir">Loans</a>
    <ul>
      <!--<li class="empty">By user</li>!-->
            <li><a href="loansgov.php?todo=40" target="iframe1">Add SSS/HDMF Loan</a></li>
            <li><a href="loansgov.php?todo=50" target="iframe1">Delete SSS/HDMF Loan</a></li>           
            <li><a href="loans.php?todo=10" target="iframe1">Add Company Loan</a></li>
            <li><a href="loans.php?todo=20" target="iframe1">View/Edit Loan</a></li>
    </ul>
  </li>    
</ul>
</div>
    <div style="
      float:right;
      padding-right:30px;
      font: bold 12px Arial, Helvetica, sans-serif;
      padding: 5px 12px;
      background-color: #bb1c23;
      border-radius: 5px;
      color: #fff;
    "><a style=" color: #fff; text-decoration: none; " href="logout.php">Logout</a>
</div>
            </td>
    <td>
      <img src="images/vectorbpo_12.jpg" width="148" height="33" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_13.jpg" width="126" height="8" alt=""></td>
    <td>
      <img src="images/vectorbpo_14.jpg" width="826" height="8" alt=""></td>
    <td>
      <img src="images/vectorbpo_15.jpg" width="148" height="8" alt=""></td>
  </tr>
  <tr>
    <td rowspan="2">
      <img src="images/vectorbpo_16.jpg" width="126" height="263" alt=""></td>
    <td style="border-radius: 0 0 25px 25px;" rowspan="3" background="images/vectorbpo_17.jpg" valign="top">
        
          <!-- start contents !-->

        <iframe  name="iframe1" width="820" height="800" frameborder="0" class="style1" > 
        
        </iframe>

            
          <!-- end contents !-->
        </td>
    <td>
      <img src="images/vectorbpo_18.jpg" width="148" height="158" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_19.jpg" width="148" height="105" alt=""></td>
  </tr>
  <tr>
    <td rowspan="2">
      <img src="images/vectorbpo_20.jpg" width="126" height="600" alt=""></td>
    <td>
      <img src="images/vectorbpo_21.jpg" width="148" height="575" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_22.jpg" width="826" height="25" alt=""></td>
    <td rowspan="3">
      <img src="images/vectorbpo_23.jpg" width="148" height="101" alt=""></td>
  </tr>
  <tr>
    <td rowspan="2">
      <img src="images/vectorbpo_24.jpg" width="126" height="76" alt=""></td>
    <td>
      <img src="images/vectorbpo_25.jpg" width="826" height="27" alt=""></td>
  </tr>
  <tr>
    <td>
      <img src="images/vectorbpo_26.jpg" width="826" height="49" alt=""></td>
  </tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>