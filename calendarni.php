<style type="text/css">
 table {
    width:210px;
    border:0px solid #888;    
    border-collapse:collapse;
}
 
td {
    width:30px;
    border-collpase:collpase;
    border:1px solid #888;
    text-align:right;
    padding-right:5px;
}
 
.days{
    background-color: #F1F3F5;
}
 
th {
    border-collpase:collpase;
    border:1px solid #888;
    background-color: #E9ECEF;
}
</style>
<?php
 
function showCalendar(){
    // Get key day informations. 
    // We need the first and last day of the month and the actual day
    $today    = getdate();
    $firstDay = getdate(mktime(0,0,0,$today['mon'],1,$today['year']));
    $lastDay  = getdate(mktime(0,0,0,$today['mon']+1,0,$today['year']));
 
    // Create a table with the necessary header informations
    echo '<table>';
    echo '  <tr><th colspan="7">'.$today['month']." - ".$today['year']."</th></tr>";
    echo '<tr class="days">';
    echo '  <td>Mo</td><td>Tu</td><td>We</td><td>Th</td>';
    echo '  <td>Fr</td><td>Sa</td><td>Su</td></tr>';
 
	// Display the first calendar row with correct positioning
    echo '<tr>';
    for($i=1;$i<$firstDay['wday'];$i++){
        echo '<td>&nbsp;</td>';
    }
    $actday = 0;
    for($i=$firstDay['wday'];$i<=7;$i++){
        $actday++;
        echo "<td>$actday</td>";
    }
    echo '</tr>';
 
    //Get how many complete weeks are in the actual month
    $fullWeeks = floor(($lastDay['mday']-$actday)/7);
 
    for ($i=0;$i<$fullWeeks;$i++){
        echo '<tr>';
        for ($j=0;$j;$j++){
            $actday++;
			echo "<td>$actday</td>";
        }
        echo '</tr>';
    }
 
    //Now display the rest of the month
    if ($actday < $lastDay['mday']){
        echo '<tr>';
 
        for ($i=0;$i;$i++){
            $actday++;
            if ($actday <= $lastDay['mday']){
                echo "<td>$actday</td>";
            }
            else {
                echo '<td>&nbsp;</td>';
            }
        }
 
 
        echo '</tr>';
    }
 
    echo '</table>';
}
 
showCalendar();
?>