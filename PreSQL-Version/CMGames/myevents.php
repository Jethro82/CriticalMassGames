<?php
session_start();
echo '<Title>My Events</Title>'.
'My Events:<br>';
if (!isset($_SESSION['useno'])){
	echo 'You are not logged on<br>';
	include 'logon.htm';
}
else {
	echo "<a href=myevents.php?disp=C>Current Events</a>&#160; &#160;
	<a href=myevents.php?disp=P>Past Events Only</a>&#160; &#160;
	<a href=myevents.php>All Events</a>&#160; &#160;
	<a href=home.php>Home</a>";

	$f='usr_'.$_SESSION['useno'];
	$disp=$_REQUEST['disp'];
	include '../eventlist.php';
}
?>
