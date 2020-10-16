<? session_start();
          ob_start();
          $filename = "data.xls";
          header("Content-Disposition: attachment; filename=\"$filename\""); 
          header("Content-Type: application/vnd.ms-excel"); 

          $con = mysqli_connect("localhost", "root", "LeadGen123","ebridge");
          if (!$con)
            {
             die('Could not connect: ' . mysql_error());
             }

            // mysql_select_db("ebridge", $con);
          
		  $before = mktime(0,0,0,date("$_POST[Month]"),date("$_POST[Day]"),date("Y"));
		  $after = mktime(0,0,0,date("$_POST[Month2]"),date("$_POST[Day2]"),date("Y"));
          $datebefore = date("Y-m-d", $before);
		  $dateafter = date('Y-m-d', $after);
			
		  $result = mysqli_query($con,"SELECT * FROM callhistory WHERE history_timestamp  >= '".$datebefore." 00:00:00' AND
		                                                         history_timestamp  <= '".$dateafter." 23:59:59'");

		  
		  //1st Line title Area
		  echo "Agent Lastname"; echo "\t";
		  echo "Agent Firstname"; echo "\t";
		  echo "Agent ID"; echo "\t";
		  echo "Phone Number"; echo "\t";
		  echo "Disposition"; echo "\t";
		  echo "Time Stamp"; echo "\t";
		  echo "Contact ID"; echo "\t";

		  
		  echo "\n";
		  
		  while($row = mysqli_fetch_array($result))
               {
			    $resultdata = mysqli_query($con,"SELECT * FROM agents WHERE agentid = '$row[agentid]'");
                $rowdata = mysqli_fetch_array($resultdata);
				
		        echo $rowdata['agentlname']; echo "\t";
		        echo "$rowdata[agentname]"; echo "\t";
		        echo "$row[agentid]"; echo "\t";
		        echo "$row[telephone]"; echo "\t";
				echo "$row[dispostion]"; echo "\t";
		        echo "$row[history_timestamp]"; echo "\t";		        
		        echo "$row[contactid]"; echo "\t";

		  
		         echo "\n";
				
               }
			   
	ob_end_flush();		   
?>