<?
if(isset($_POST['task']) && $_POST['task']=='sendemail'){
	$fullname=$_POST['fullname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$location=$_POST['location'];
	$howdidyoufindus=$_POST['howdidyoufindus'];
	$comments=$_POST['comments'];

	

	echo $fullname." ";
	echo $email." ";
	echo $phone." ";
	echo $location." ";
	echo $howdidyoufindus." ";
	echo $comments." ";
	
  if (empty($fullname)) {
    echo 'Blank Name ';
  }
	
	
  if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
    echo "Valid email address.";
  }else{
    echo "Invalid email address.";
  }	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Vector BPO</title> 
<meta name="description" content="" /> 
<meta name="keywords" content="" /> 
<link href="css/main.css" type="text/css" rel="stylesheet" media="screen" /> 
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="js/OS-browser-detect.js"></script> 
<!--[if lte IE 6]>
<script type="text/javascript" src="js/iepngfix_tilebg.js"></script>
<script type="text/javascript" src="js/ie6pnghover.js"></script>
<link href="css/ie6-hoveranything-pngsupport.css" type="text/css" rel="stylesheet" media="screen" />
<![endif]--> 
<script type="text/javascript" src="js/cufon-files.js"></script> 
<script type="text/javascript" src="js/cufon-styles.js"></script> 
<script type="text/javascript" src="p7pm/p7popmenu.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<style type="text/css" media="screen"> 
<!--
@import url("p7pm/p7pmh0.css");
-->
</style> 
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head> 
<body onload="P7_initPM(1,0,1,-20,10)" class="inner"> 

 <div class="topbg">
  <div class="container">

   <div id="display-area">
    <div class="col1 left">

    </div>
    <div class="col2 right">
     <h1>WE'D LOVE TO HEAR FROM YOU</h1>
     <div class="address">
      <div class="address-info left">
       <div class="address-branch">
       <?php
	   
	   echo date();
	   
	   ?>
        <h4>VECTOR BPO USA</h4>
        <p>316 California Ave #848</p>
		<p>Reno, NV 89509 USA</p>
        <h6>Phone: 800 - 454 - 9656</h6>
       </div>
       <div class="address-branch">
        <h4>VECTOR BPO PHILIPPINES</h4>
        <p>72 N Escario St 8th floor</p>
        <p>Cebu City, Cebu Philippines 6000</p>
        <h6>Phone: 63 32 - 253 - 8988</h6>
       </div>
      </div>
      <div class="location-map right">
       <img alt="map" src="images/map-img.jpg" />
      </div>
      <div class="clr"></div>
     </div><!--end of address-->
     <div class="contact-form">
      <h4>SEND US A MESSAGE</h4>
      <p>Thank you for your interest in Vector BPO. Help us serve you better by providing some information.</p>
      <form name = "" action="" method="post">
       <table cellpadding="0" cellspacing="0">
        <tr>
         <td>
          <label>Your Name <span>*</span></label>
         </td>
        </tr>
        <tr>
         <td>
          <div class="textfield">
           <span id="sprytextfield1">
           <input type="text" name="fullname" />
           <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span></span> </div>
         </td>
        </tr>
        <tr>
         <td>
          <label>Your Email<span>*</span></label>
         </td>
        </tr>
        <tr>
         <td>
          <div class="textfield">
           <span id="sprytextfield2">
           <input type="text" name="email" />
           <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></div>
         </td>
        </tr>
        <tr>
         <td>
          <label>Phone Number (optional)</label>
         </td>
        </tr>
        <tr>
         <td>
          <div class="textfield">
           <input type="text" name="phone" />
          </div>
         </td>
        </tr>
        <tr>
         <td>
          <label>Location</label>
         </td>
        </tr>
        <tr>
         <td>
          <div class="textfield">
           <input type="text" name="location" />
          </div>
         </td>
        </tr>
        <tr>
         <td>
          <label>How did you find us?</label>
         </td>
        </tr> 
        <tr>
         <td>
          <div class="textfield">
           <input type="text" name="howdidyoufindus" />
          </div>
         </td>
        </tr>
        <tr>
         <td>
          <div class="txtarea"> 
           <textarea rows="6" cols="20" name="comments"></textarea>
          </div>
         </td>
        </tr>
        <tr>
         <td>
          <input type="submit" class="btn-submit" name="submit" value="" />
         </td>
        </tr>
       </table>
       <input type="hidden" name="task" value="sendemail" />
      </form>
     </div><!--end of contact-form-->
    </div>
    <div class="clr"></div>
   </div><!--end of display-area-->
  </div>

 </div>
   
<script type="text/javascript" src="js/withSubMarker.js"></script>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:5, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["blur", "change"]});
//-->
</script>
</body> 
</html>