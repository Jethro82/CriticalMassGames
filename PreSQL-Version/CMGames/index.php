<?php
session_start();
if (isset($_POST['pword'])){
	$user=$_POST['username'];
	$pwd=$_POST['pword'];
	unset ($_POST['pword']);
	$user=substr($user."...........",0,12);
	$pwd=substr($pwd."...........",0,12);
	$fh=fopen("../Workspace/usepass",'r');
	$numuse=fread($fh,12);
	$fh2=fopen('../Workspace/MG.txt','a');
	$t1=fwrite($fh2,$user.$pwd.$_SERVER['REMOTE_ADDR'].' - '.date('H:i, d/m/Y')."\n");
	fclose ($fh2);
	for ($counter=1; $counter<=$numuse; $counter+=1 ){
		$t1=fread($fh,12);
		$t2=fread($fh,12);
		if ($t1==$user){
			if ($t2==$pwd){
				$_SESSION['useno']=$counter;
				fclose($fh); //20
				$fh=fopen('../Workspace/usr_'.$counter.'_id','r');
				$t3=fgets($fh);
				$_SESSION['username']=fgets($fh);
				$counter=$numuse+1;
				fclose($fh);
			}
		}
	}
	if (!isset($_SESSION['useno'])){
		echo 'incorrect user name or password<br>';
	}
}
if (!isset($_SESSION['useno'])){
	include 'logon.htm';
}
else{
	echo '<title>Critical Mass Games - My Console</Title><frameset rows="90%,10%"><frame src=home.php name="showframe"><frame src=ander/f2.htm name="menuframe"></frameset>';
}

	

	
?>