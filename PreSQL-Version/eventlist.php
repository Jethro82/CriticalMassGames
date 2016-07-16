<?php
$fh=fopen('../Workspace/el/'.$f,'r');
$numev=trim(fread($fh,12));
echo '<table align=center width=80%>';
$pevents='<td valign=top>Past Events:';
$cevents="<td Valign=top>Today's and Upcoming Events:";
for ($counter=1; $counter<=$numev; $counter+=1){
	$cev=trim(fread($fh,12));
	if (file_exists('../Workspace/evn_'.$cev.'_desc')){
		$fh2=fopen('../Workspace/evn_'.$cev.'_desc','r');
		$evname=fgets($fh2);
		$t1=fgets($fh2);
		$evgam=fgets($fh2);
		$t1=fgets($fh2);
		$dt=fgets($fh2);
		$dt2=substr(trim($dt),-2).substr($dt,2,4).substr($dt,0,2);
		if ($dt2<date('y/m/d')){
			$pevents.='<br><a href=event.php?evno='.$cev.' title="'.$evgam.'">'.$evname.'</a>('.$dt.')';
		}
		else { //20
			$tm=fgets($fh2);
			$cevents.='<br><a href=event.php?evno='.$cev.' title="'.$evgam.'">'.$evname.'</a>('.substr($tm,0,5).', '.$dt.')';
		}
		fclose($fh2);
	}
}
fclose ($fh);
if ($disp!='P'){
	echo $cevents;
	if ($cevents=="<td Valign=top>Today's and Upcoming Events:"){
		echo '<br>{NONE}';
	}
}
if ($disp!='C'){
	echo $pevents;
	if ($pevents=="<td valign=top>Past Events:"){
		echo '<br>{NONE}';
	}

}
echo '</table>';
?>