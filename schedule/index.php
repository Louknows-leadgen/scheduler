<?php
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Digital Connection I.T. Services</title>

<link href="../stylelog.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<div id="layer02_holder">
  <div id="left"></div>
  <div id="center"></div>
  <div id="right"></div>
</div>

<div id="layer03_holder">
  <div id="left"></div>
    <div id="left"></div>
  <div id="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><br /><br /></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="checklogin.php">
      <label>EmployeeID
        <input name="agentid" type="text" id="agentid" class="thisinput" />
      </label>
      <label>Password :   
        <input type="password" name="password" id="password" class="thisinput" style="margin-top:5px;" />
      </label>
      <label>
       <input type="submit" name="button" id="button" value="Login" />
      </label>
    </form>    </td>
  </tr>
</table>
  </div>
</div>
</center>
<div id="layer04_holder"></div>
<div style="clear: both;">&nbsp;</div>
<div id="layer05_holder" >
 Copyright © 2017, Digital Connection I.T. Services. Powered by <img src="images/animated_favicon1.gif" border="0" />
</div>
</body>
</html>