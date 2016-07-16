<?php
session_start();
include '../CheckGroupStat.php';
include '../givetake.php';
$t1=$_SESSION['useno'];
$lg=htmlspecialchars($_GET['lg']);
if (file_exists('../Workspace/lg_'.$lg.'_desc')){
	if (($t1>0) and (GroupStat($lg,$t1)=='Q')){
		$fh=fopen('../Workspace/lg_'.trim($lg).'_desc','r');
		$t2=fgets($fh);
		$t2=fgets($fh);
		$t2=fgets($fh);
		$t2=trim(fgets($fh));
		fclose($fh);
		if (($t2=='OPEN')){
			echo 'You are now a member of this Group';
			$t2=Int8($t1).'M';
		}
		else{
			echo 'Your application for membership has been recieved';
			$t2=Int8($t1).'P';
		}
		echo '<br>';
		$fh=fopen('../Workspace/lg_'.$lg.'_usr','r+');
		$t2=listadd($fh,$t2);
		$fh=fopen('../Workspace/lg/usr_'.$t1,'r+');
		$t2=listadd($fh,$lg);

	}
}
include '../Group_tmp.php';
?>