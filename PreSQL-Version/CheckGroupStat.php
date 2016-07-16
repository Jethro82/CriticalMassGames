<?php
$RTtl = array('S' => 'SUSPENDED','Q' => '','P' => 'Pending', 'M' => 'Member', 'J' => 'Jnr Officer', 'G' => 'Snr Officer', 'C' => 'President'); 
function GroupStat($lg, $usr){
	$fh=fopen("../Workspace/lg_".$lg."_usr",'r');
	$nummem=fread($fh,12);
	for ($counter=1; $counter<=$nummem; $counter+=1){
		$t1=fread($fh,8);
		if (trim($t1)==trim($usr)){
			return fread($fh,1);
			fclose ($fh);
		}
		$t1=fread($fh,4);
	}
	fclose ($fh);
	return 'Q';
}
?>