<?php
 include("db_connect.php");

date_default_timezone_set('Asia/Hong_Kong');
//check if time is set in the URL
if(isset($_GET['time']))
	$time = $_GET['time'];
else
	$time = time();


$today = date("Y/n/j", time());

$current_month = date("n", $time);

$current_year = date("Y", $time);

$current_month_text = date("F Y", $time);

$total_days_of_current_month = date("t", $time);

$events = array();

//query the database for events between the first date of the month and the last of date of month
$result = mysql_query("SELECT DATE_FORMAT(eventDate,'%d') AS day,eventContent,eventTitle,id FROM eventcal WHERE eventDate BETWEEN  '$current_year/$current_month/01' AND '$current_year/$current_month/$total_days_of_current_month'");
$xs=0;
while($row_event = mysql_fetch_object($result))
{
	//loading the $events array with evenTitle and eventContent inside the <span> and <li>. We will add then inside <ul> in the calender
	$contentevent=nl2br(stripslashes($row_event->eventContent));
	$events[intval($row_event->day)] .= '<li><span class="title">'.stripslashes($row_event->eventTitle).'</span><span class="desc">'.$contentevent.'</span><div style="display: none" id="trial'.$xs.'"><span class="lcdstyle1">'.stripslashes($row_event->eventTitle).'</span><br>'.stripslashes($row_event->eventContent).'</div></li>';

$xs++;
}							

$first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);

//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
$first_w_of_month = date("w", $first_day_of_month);

//how many rows will be in the calendar to show the dates
$total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);

//trick to show empty cell in the first row if the month doesn't start from Sunday
$day = -$first_w_of_month;


$next_month = mktime(0,0,0,$current_month+1,1,$current_year);
$next_month_text = date("F \'y", $next_month);

$previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
$previous_month_text = date("F \'y", $previous_month);

$next_year = mktime(0,0,0,$current_month,1,$current_year+1);
$next_year_text = date("F \'y", $next_year);

$previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
$previous_year_text = date("F \'y", $previous_year);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Calendar</title>
<!-- <link type="image/x-icon" href="images/heart.ico" rel="shortcut icon"/> -->
<meta name="author" content="Reymond Buenaviaje, Cane Events" />
<meta name="copyright" content="Copyright 2009 Cane Events" />
<link rel="stylesheet" type="text/css" href="style.css"/>
	
	<script src="js/jquery.validate.js" type="text/javascript"></script>
    <script src="js/loginjquery.js"></script>
	<script type="text/javascript" src="jquery.js"></script>
    	
	<script type="text/javascript" src="jquery-color.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<!-- stylesheets -->
  	<link rel="stylesheet" href="css/stylea.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- jQuery - the core -->
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="style.css"/>
<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="facebox/facebox.js" type="text/javascript"></script> 
<link rel="stylesheet" href="css/master.css" type="text/css" media="screen" charset="utf-8" />

<script src="js/coda.js" type="text/javascript"> </script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#facebox').facebox({
        loadingImage : 'facebox/loading.gif',
        closeImage   : 'facebox/closelabel.png'
      })
    })
  </script>

<style>
.lcdstyle1{ /*Example CSS to create LCD countdown look*/

color:black;
font: bold 24px Arial;

}
</style>
<script>
function addnewevent(years,months,days)
{
	alert(years+'-'+months+'-'+days);
	}
</script>
</head>

<body >
	
<table border="0" cellspacing="0" cellpadding="0" width="750" align="center">



<TR><TD colspan="2" style="padding-bottom:5px;" width="100%" align="center" >


	
	<h2 class="calendar"><?=$current_month_text?></h2>
	<table cellspacing="0" class="calendar">
		<thead>
		<tr>
			<th>Sun</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
		</tr>
		</thead>
		<tr>
			<?php
			for($i=0; $i< $total_rows; $i++)
			{
				for($j=0; $j<7;$j++)
				{
					$day++;					
					
					if($day>0 && $day<=$total_days_of_current_month)
					{
						//YYYY-MM-DD date format
						$date_form = "$current_year/$current_month/$day";
						?>
                        <td id="facebox" <?
						
						//check if the date is today
						if($date_form == $today)
						{
							echo ' class="today"';
						}
						
						//check if any event stored for the date
						if(array_key_exists($day,$events))
						{
							//adding the date_has_event class to the <td> and close it
							echo ' class="date_has_event"> '.$day;
							
							//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
							echo '<div class="events"><ul>'.$events[$day].'</ul></div>';
						}
						else 
						{
							//if there is not event on that date then just close the <td> tag
							echo '> '.$day;
						}
						
						echo "</td>";
					}
					else 
					{
						//showing empty cells in the first and last row
						echo '<td class="padding">&nbsp;</td>';
					}
				}
				echo "</tr><tr>";
			}
			
			?>
		</tr>
		<tfoot>		
			<th>
				<a href="<?=$_SERVER['PHP_SELF']?>?time=<?=$previous_year?>" title="<?=$previous_year_text?>"><span>&laquo;&laquo;</span></a>
			</th>
			<th>
				<a href="<?=$_SERVER['PHP_SELF']?>?time=<?=$previous_month?>" title="<?=$previous_month_text?>"><span>&laquo;</span></a>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>
				<a href="<?=$_SERVER['PHP_SELF']?>?time=<?=$next_month?>" title="<?=$next_month_text?>"><span>&raquo;</span></a>
			</th>
			<th>
				<a href="<?=$_SERVER['PHP_SELF']?>?time=<?=$next_year?>" title="<?=$next_year_text?>"><span>&raquo;&raquo;</span></a>
			</th>		
		</tfoot>
	</table>


		
	      </TD>
		

</TR>

</table>
</div>
</body>
</html>
