<?
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Digital Connection I.T. Services</title>
<link href="stylelog.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <div id="login_form">
      <div id="main_logo">
        <h1><a href="http://payroll.digicononline.com/payslip/index.php">Digital Connection I.T. Services</a></h1>
      </div><!---main_logo--->
        <div id="actual_login">
          <div id="round_logo">
            <h2>Digital Connection Global Solution</h2>
          </div>
          <div id="login_name">LOGIN</div>
              <form id="form1" name="form1" method="post" action="checklogin.php">
                <div id="employee_id">
                  <label>Employee ID :</label>
                    <input name="agentid" type="text" id="agentid" class="thisinput"  />
                </div><!---employee_id--->
                <div id="password_id">
                  <label>Password : </label>  
                    <input type="password" name="password" id="password" class="thisinput" style="margin-top:-2px;" />
                </div><!---password_id--->
                <div id="submit_button">
                  <label>
                    <input type="submit" name="button" id="button" value="Login" />
                  </label>
                </div><!---submit_button--->
            </form>
        </div><!---actual_login--->
        <footer>
          <h6>2015 Xactcall Corporation All rights reserved. </h6>
        </footer>
  </div><!---login_form--->
</body>
</html>