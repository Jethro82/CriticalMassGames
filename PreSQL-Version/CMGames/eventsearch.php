<?php
include 'setEsearch.php';
echo '<br><br>';
include '../checkformat.php';
$tvar2=$_POST['sdate'];
$sdate=substr($tvar2,-4).substr($tvar2,2,4).substr($tvar2,0,2);
if ((checkformat($sdate,'####/##/##')!='correct') or ($sdate<date('Y/m/d'))){
	$sdate=date('Y/m/d');
}
$tvar2=$_POST['ldate'];
$ldate=substr($tvar2,-4).substr($tvar2,2,4).substr($tvar2,0,2);
if (checkformat($ldate,'####/##/##')!='correct'){
	$ldate='9999/12/31';
}
if (checkformat($_POST['stime'],'##:##')=='correct'){
	$stime=$_POST['stime'];
}else{
	$stime='00:00';
}
if (checkformat($_POST['ltime'],'##:##')=='correct'){
	$ltime=$_POST['ltime']; //20
}else{
	$ltime='23:59';
}
$cat=substr($_POST['Category'],-1);
$catname=substr($_POST['Category'],0,-1);
$ssgam=trim($_POST['GameString']);
$ssev=trim($_POST['EventString']);
$regcode=$_POST['regcode'];
echo 'Displaying all matching events in '.$catname.' between '.$sdate.' and '.$ldate.' starting between '.$stime.' and '.$ltime.' (in Region:'.$regcode.')<br>';

echo '<table><td>Event Name<td>Game<td>Date<td>Start Time<tr>';
$fh=fopen('../Workspace/srch_tbls/EVN_CAT_.'.$cat,'r+');
$numEv=fread($fh,12);
$hit='no';
for ($counter=1; $counter<=$numEv; $counter+=1){
	$dt=fread($fh,10);
	$dt=substr($dt,-4).substr($dt,2,4).substr($dt,0,2);

	$tm=fread($fh,5);
	$rg=fread($fh,5);
	$gm=fread($fh,70);
	$evna=fread($fh,70);
	$evno=trim(fread($fh,8)); //40
	$thit='yes';
	if (($tm<$stime) or ($tm>$ltime)){
		$thit='';
	}
	if (($dt<$sdate) or ($dt>$ldate)){
		$thit='';
	}
	if ($ssgam!=''){
		if ((strpos('!'.$gm,$ssgam)==false)){
			$thit='';
		}
	}
	if ($ssev!=''){
		if (strpos('!'.$evna,$ssev)==false){
			$thit='';
		}
	}
	if ($regcode!=$rg){ //60
		$thit='';
	}
	$efile="../Workspace/evn_".$evno."_desc";
	if ($thit==yes){
		if (!file_exists($efile)){
			$thit='';
		}
	}
	if ($thit=='yes'){ 
		echo '<td><a href="event.php?evno='.$evno.'">'.$evna.'</a><td>'.$gm.'<td>'
		 .$dt.'<td>'.$tm.'<tr>';
		$hit='';
	}
}
if ($hit=='no'){
	echo '<td>{No Such Events found}';
}
?>
</table>