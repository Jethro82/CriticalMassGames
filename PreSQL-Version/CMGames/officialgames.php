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
		echo '<Title>'.$t1.' - Official Games</Title>';
		fclose($fh);
		include '../CheckGroupStat.php';
		$rnk=GroupStat($lg,$_SESSION['useno']);
		if ($rnk>'M'){
			echo 'You are not a member in good standing of this Group';
		}
		else{
			echo $t1.' Group<br>'.
			'<a href=Group.php?lg='.$lg.">Return to Group Page</a>&#160; &#160; &#160; <a href=home.php>Home</a>&#160; &#160; &#160; ";
			if ($rnk<='J'){
				echo '<a href=createevent.php?lg='.$lg.'&lgt=1>Create official game</a>';
			}
			$f='lg_of_'.$lg;
			include '../eventlist.php';
		}
	}
}
?>