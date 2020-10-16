<?
$dbcnx = @mysql_connect("97.74.31.27","jpny", "A135369a");
if (!$dbcnx) {
echo( "<P>Unable to connect to the " ."database server at this time.</P>" );
exit();
   }


if (! @mysql_select_db("jpny") ) {
echo( "<P>Unable to locate the uploads " .
           "database at this time.</P>" );
     exit();
  }

  ?>
