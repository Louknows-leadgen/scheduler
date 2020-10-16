<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action = "viewytd.php" method = "post">

       <p> Year : 
         <select name="Year">
           <option value="2016">2016</option>
           <option value="2017">2017</option>
           <option value="2018">2018</option>
         </select>
         </p>
         <input type = "hidden" name ="todo" value = "15"/>
         <input type="submit" name="generate" value="View Year to Date" />

</form> 
</body>
</html>