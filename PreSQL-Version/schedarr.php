<?php
function str2arr($sched){
	return array( hexdec(substr($sched,0,6)) , hexdec(substr($sched,6,6)) , hexdec(substr($sched,12,6)), hexdec(substr($sched,18,6)), 
	  hexdec(substr($sched,24,6)),  hexdec(substr($sched,30,6)), 	 	hexdec(substr($sched,36,6)) );
}
function ar2str($schedarr){
	for ($count=0; $count<7; $count+=1){
		$outs.=substr('00000'.dechex($schedarr[$count]),-6);
	}
	return $outs;
}
?>