<?
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Digital Connection I.T Services</title>
<link href="stylelog.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <div id="payroll_wrapper">
    <div id="header_logo">
      <h1><a href="">Digital Connection I.T. Services</a></h1>
    </div><!---header_logo--->
    <div id="payroll_form">
          <div id="left_logo">
              <img id="left_images" src="images/big_logo.png">
          </div><!---left_logo--->
          <div id="login_form1">
            <h2>Login</h2>
          <form id="form1" name="form1" method="post" action="checklogin.php">
          <label id="label_employee">Employee ID :
            <input name="agentid" type="text" id="agentid" class="thisinput" />
          </label>
          <label id="label2">Password :   
            <input type="password" name="password" id="password" class="thisinput" />
          </label>
          <label>
            <input type="submit" name="button" id="button" value="Login" />
          </label>
        </form>
          </div><!---login_form1--->
    </div><!---payroll_form--->
    <footer>
      <h6>2017 Digital Connection I.T. Services All rights reserved. </h6>
    </footer>
  </div><!---payroll_wrapper--->
</body>
</html>