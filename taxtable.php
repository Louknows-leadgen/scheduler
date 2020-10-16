<style type="text/css">
  body,td,th {
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 12px;
  }

  table {
    border-collapse: collapse;
    width: 80%;
    margin: auto;
  }

  table, th, td {
    border: 1px solid black;
  }

  th, td{
    padding: 10px;
    text-align: center;
  }

  tr:hover {
    background-color: #fff;
  }

</style>

<?php 
if(isset($_GET['todo']) && $_GET['todo']== '10'){
  $con = mysqli_connect("localhost","digicono_HRadmin","DigiC0n0nlin3!","internal");
  if (!$con){
    die('Could not connect: ' . mysqli_connect_error());
  }
?>

<p>Tax Table Rate For Semi-Monthly</p>
<table width="" border="0">
  <thead>
      <tr align="center">
        <th></th>
        <?php
            $qh = "
                SELECT @rownum := @rownum + 1 as row_number
                FROM(
                    SELECT DISTINCT percentofexcessamount
                    FROM prltaxtablerate
                ) t
                cross join (select @rownum := 0) r
            ";

            $result_h = mysqli_query($con,$qh);
            $headers = mysqli_fetch_all($result_h,MYSQLI_ASSOC);
            mysqli_free_result($result_h);

            foreach ($headers as $h) {
              $header = $h['row_number'];
              echo "<th>$header</th>";
            }
        ?>
      </tr>
  </thead>
  <tbody>
    <?php
        // Query necessary data from the database

        $qstat = "SELECT DISTINCT taxstatusid FROM prltaxtablerate ORDER BY taxstatusid";

        $result_stat = mysqli_query($con,$qstat);
        $taxstatusids = mysqli_fetch_all($result_stat,MYSQLI_ASSOC);
        mysqli_free_result($result_stat);

        $qpct = "SELECT DISTINCT percentofexcessamount, fixtax FROM prltaxtablerate ORDER BY percentofexcessamount";

        $result_pct = mysqli_query($con,$qpct);
        $percentofexcessamounts = mysqli_fetch_all($result_pct,MYSQLI_ASSOC);
        mysqli_free_result($result_pct);

        
        // Start displaying the records

        // display Fixed Tax
        echo "<tr>";
        echo "<td><strong>FA</strong></td>";
        foreach ($percentofexcessamounts as $f) {
          $fixtax = $f['fixtax'];
          echo "<td>$fixtax</td>";
        }
        echo "</tr>";


        // display Percent of excess amount
        echo "<tr>";
        echo "<td><strong>%</strong></td>";
        foreach ($percentofexcessamounts as $p) {
          $percentofexcessamount = $p['percentofexcessamount'];
          echo "<td>$percentofexcessamount</td>";
        }
        echo "</tr>";

        // Display rangefrom value of each tax status per percent of excess amount
        foreach ($taxstatusids as $t) {
          $taxstatusid = $t['taxstatusid'];
          echo "<tr>";
          echo "<td><strong>$taxstatusid</strong></td>";
          foreach ($percentofexcessamounts as $pct) {
            $percentofexcessamount = $pct['percentofexcessamount'];
            $qrfrom = "SELECT rangefrom FROM prltaxtablerate WHERE taxstatusid = '$taxstatusid' AND percentofexcessamount = $percentofexcessamount";
            $result_rfrom = mysqli_query($con,$qrfrom);
            $rangefrom = mysqli_fetch_assoc($result_rfrom);
            mysqli_free_result($result_rfrom);
            echo "<td>". $rangefrom['rangefrom'] ."</td>";
          }
          echo "</tr>";
        }
    ?>
  </tbody>
</table>

<?php } ?>