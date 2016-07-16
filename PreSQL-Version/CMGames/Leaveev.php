<?php
include '../checkev.php';
include '../givetake.php';
$evno=htmlspecialchars($_REQUEST['evno']);
$e="../Workspace/evn_".$evno."_prt";
if (file_exists($e)){
	session_start();
	include '../CheckGroupStat.php';
	$t1=EvUseCheck($evno);
}
if ($t1=="Leave"){
	if (htmlspecialchars($_GET['cnf'])=='y'){
		$fh=fopen($e,'r+');
		$useno=$_SESSION['useno'];
		$t1=listtake($fh,$useno);
		$fh=fopen("../Workspace/el/usr_".trim($useno),'r+')  or die("can't open file");
		$t2=listtake($fh,$evno); //20
		if ($t1==0){
			$fh=fopen('../Workspace/evn_'.$evno.'_desc','r');
			$t2=fgets($fh);
			$t2=fgets($fh);
			$t2=fgets($fh);
			$t2=fgets($fh);
			$t2=fgets($fh);
			$t2=fgets($fh);
			$t2=trim(fgets($fh));
			fclose($fh);
			if ($t2>0){
				$fh=fopen('../Workspace/el/lg_cl_'.$t2,'r+');
				$t1=listtake($fh,$evno);
			}
			unlink("../Workspace/evn_".trim($evno)."_prt");
			unlink("../Workspace/evn_".trim($evno)."_desc");
		}
		echo "Successfully Exited";
	}
	else{
		echo 'Are you sure you want to WITHDRAW from this event?<br>'
		 .'<a href=Leaveev.php?evno='.$evno.'&cnf=y>Yes</a>&#160; &#160; '
		 .'<a href=event.php?evno='.$evno.'>No</a><br>';
	}
}
else{
	echo "**- ".$t1," -**";
}  //60
echo "<br>";
include "../evnt_tmplt.php";
?>