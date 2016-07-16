<?php
function EvUseCheck($evno){
	if (!isset($_SESSION['useno'])){
		return "You are not logged in";
	}
	$useno=$_SESSION['useno'];
	$fh=fopen("../Workspace/evn_".$evno."_prt",'r') or die("can't open file");
	$numpar=fread($fh,12);
	for ($counter=1; $counter<=$numpar; $counter+=1){
		$tvar=fread($fh,12);
		if (trim($tvar)==trim($useno)){
			$tv2="Leave";
			$counter=$numpar;
		}
	}
	fclose($fh);
	$fh=fopen("../Workspace/evn_".$evno."_desc",'r') or die("can't open file");
	$tvar=fgets($fh);  
	$tvar=fgets($fh); //20
	$tvar=fgets($fh);
	$tvar=fgets($fh);
	$tvar2=fgets($fh);
	$tvar=fgets($fh);
	$tvar=fgets($fh);
	$tvar2=substr(trim($tvar2),-2).substr($tvar2,2,4).substr($tvar2,0,2);
	if ($tvar2<date('y/m/d')){
		fclose ($fh);
		return "this event has passed";
	}
	if (trim($tvar)!=0){
		if (GroupStat(trim($tvar),$useno)>'M'){
			return "You are not a member of this Group";
		}
	}
	$tvar=fgets($fh);
	if ($tv2=="Leave"){
		fclose($fh);
		if (trim($tvar)==trim($numpar)){
			return "Critical Mass - cannot leave";
		}
		else{
			return "Leave";
		}
		
	}
	$tvar=fgets($fh);
		fclose($fh);
	if (trim($tvar)==trim($numpar)){
		return "Event Full";}
	return "Join ";}
?>