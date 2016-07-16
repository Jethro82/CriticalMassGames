<?php
session_start();
include '../CheckGroupStat.php';
include '../givetake.php';
$t1=$_SESSION['useno'];
$lg=htmlspecialchars($_GET['lg']);
if (file_exists('../Workspace/lg_'.$lg.'_desc')){
	$rnk=GroupStat($lg,$t1);
	if (($t1>0) and ($rnk!='S') and ($rnk!='C') and ($rnk!='N')){
		if (htmlspecialchars($_GET['cnf'])=='y'){
			$fh=fopen('../Workspace/lg_'.$lg.'_usr','r+');
			$t2=INT8($t1).$rnk;
			$t2=listtake($fh,$t2);
			$fh=fopen('../Workspace/lg/usr_'.$t1,'r+');
			$t2=listtake($fh,$lg);
		}
		else{
			echo 'Are you sure you want to WITHDRAW from this Group?<br>'
			 .'<a href=lGroup.php?lg='.$lg.'&cnf=y>Yes</a>&#160; &#160; '
			 .'<a href=Group.php?lg='.$lg.'>No</a><br>';
		}
		
	}
}
include '../Group_tmp.php';
?>