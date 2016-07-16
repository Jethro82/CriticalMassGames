<?php
include '../checkev.php';
include '../givetake.php';
$evno=htmlspecialchars($_REQUEST['evno']);
$e="../Workspace/evn_".$evno."_prt";
$rec='';
if (file_exists($e)){
	session_start();
	include '../CheckGroupStat.php';
	$t1=EvUseCheck($evno);
}
if ($t1=="Join "){
	$fh=fopen($e,'r+');
	$useno=$_SESSION['useno'];
	$useno="    "+int8($useno);
	$t1=listadd($fh,$useno);
	$fh=fopen("../Workspace/el/usr_".$useno."",'r+')  or die("can't open file");
	$evno="    "+int8($evno);  
	$t2=listadd($fh,$evno); //20
	$fh=fopen("../Workspace/evn_".$evno."_desc",'r')  or die("can't open file"); 
	$subject=trim(fgets($fh));
	$t2=fgets($fh);
	$t2=fgets($fh);
	$t2=fgets($fh);
	$t2=fgets($fh);
	$t2=fgets($fh);
	$t2=fgets($fh);
	$t2=fgets($fh);
	fclose($fh);
	if ($t2==$t1){
		$fh=fopen($e,'r');
		$t2=fread($fh,12);
		for ($counter=1; $counter<=$t1;$counter+=1){
			$t2=fread($fh,12);
			$fh2=fopen("../Workspace/usr_".trim($t2)."_id",'r');
			$t3=fgets($fh2);
			$t3=fgets($fh2);
			$t3=fgets($fh2); 
			if (trim($t3)=="YES"){//40
				$t3=fgets($fh2);
				$t3=fgets($fh2);
				$rec=$rec.$t3.", ";
			}
			fclose($fh2);
		}
		fclose($fh);
	}
	echo "Game Successfully Joined";
		if ($rec!=''){
			$to      = "";
			$message = $subject." has Critical Mass - CMGames";
			$headers = "From: blackhole@criticalmass.ca\r\nBcc: ".substr($rec,0,-1)."\r\n X-Mailer:PHP/5";
			echo '<Script>';
			mail($to, $subject, $message, $headers);
			echo '</Script>';
		}

}
else{
	echo "**- ".$t1," -**";
}  //60
echo "<br>";
include "../evnt_tmplt.php";
?>