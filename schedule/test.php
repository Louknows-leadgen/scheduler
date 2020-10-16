<?php
function checkDateFormat(&$data){
preg_match_all('/(20\d{2})\-(0[1-9]|1[012])\-(0[1-9]|[12]\d|3[01])/', $data, $matches, PREG_SET_ORDER);
$orderDates=array();
for ($i = 0; $i < count($matches); $i++) {
if(checkdate($matches[$i][2],$matches[$i][3],$matches[$i][1])){
$orderDates[]=strtotime($matches[$i][0]);
}
}
sort($orderDates);
$output=false;
for ($i=0;$i<sizeof($orderDates);$i++) {
if ($i!=0) {
$output.= ',';
}
$output.= date('Y-m-d',$orderDates[$i]);
}
if($output){
return $output;
} else {
return false;
}
}
$str = '2008-02-29,2007-02-29,2004-07-07,2035-13-00,2005-04-25'; // 2008 was a leap year
echo checkDateFormat($str);
?>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/anytime.js"></script>
<link rel="stylesheet" type="text/css" href="css/anytime.css" /><br />

English: <input type="text" id="field1" size="50"
    value="Sunday, July 30th in the Year 1967 CE" onclick="AnyTime.picker()" /><br/>
Español: <input type="text" id="field2" value="12:34" />
<script type="text/javascript">

  AnyTime.picker($(this), 
      { format: "%W, %M %D in the Year %z %E", firstDOW: 1 } );

  $("#field2").AnyTime_picker( 
      { format: "%H:%i", labelTitle: "Hora",
        labelHour: "Hora", labelMinute: "Minuto" } );
</script>