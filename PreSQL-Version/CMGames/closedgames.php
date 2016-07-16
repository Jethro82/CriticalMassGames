<?php
session_start();
if (!isset($_SESSION['useno'])){
	echo 'You are not logged in';
}
else{
	$lg=htmlspecialchars($_REQUEST['lg']);
	if (!file_exists('../Workspace/lg_'.$lg.'_desc')){
		echo "Group does not exist";
	}
	else{
		$fh=fopen('../Workspace/lg_'.$lg.'_desc','r');
		$t1=fgets($fh);
		echo '<Title>'.$t1.' - Closed Games</Title>';
		fclose($fh);
		include '../CheckGroupStat.php';
		if (GroupStat($lg,$_SESSION['useno'])>'M'){
			echo 'You are not a member in good standing of this Group';
		}
		else{
			echo $t1.' Group<br>'.
			'<a href=Group.php?lg='.$lg.">Return to Group Page</a>&#160; &#160; &#160; <a href=home.php>Home</a>&#160; &#160; &#160; ".
			'<a href=createevent.php?lg='.$lg.'>Create closed game</a>';
			$f='lg_cl_'.$lg;
			include '../eventlist.php';
		}
	}
}
?>