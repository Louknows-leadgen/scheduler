<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action = "createpayroll.php" method = "post">
  <p>Generate Payroll</p>
       <p>
         Payroll ID:
         <input type="text" name="payrollid"/>
  </p>
       <p>Payroll Description:
         <input type="text" name="payrolldescription"/>
       </p>
       <p>
         Working Days for this Cut-off:
         <input name="workingdays" type="number" min="1" max="15"/>
  </p>
       <p>
         <select name="Month">
           <option value="00">Month</option>
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
         
         <select name="Period">
           <option value="">Pay Period</option>
           <option value="10th">10th</option>
           <option value="25th">25th</option>
         </select> 
         <input type = "hidden" name ="todo" value = "15"/>
         <input type="submit" name="generate" value="Create Pay Period" />
       </p>
</form> 
</body>
</html>