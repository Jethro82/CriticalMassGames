<?php
$_SESSION['LGame']=0;
if(isset($_SESSION['username'])){
	echo "Hello ".$_SESSION['username']."<br>";
	$useno=$_SESSION['useno'];
	$fh=fopen("../Workspace/el/usr_".$useno,"r");
	$numev=fread($fh,12);
	if ($numev>=1){
		echo "My most recently added events";
		if ($numev>10) {
			$tvar=fseek($fh,12*($numev-9));
			$numev=10;
			echo '(<a href=myevents.php>All Events</a>)';
		}
		echo '<br>';
		for ($counter=1; $counter<=$numev; $counter+=1){
			$evno=trim(fread($fh,12));
			$fh2=fopen("../Workspace/evn_".$evno."_desc",'r');
			$tvar=fgets($fh2);
			$t2=fgets($fh2);
			$t2=fgets($fh2);
			fclose ($fh2); //20
			echo "<a href=event.php?evno=".$evno.' title="'.trim($t2).'">'.$tvar."</a><br>";  
		}
	}
	$fh=fopen('../Workspace/lg/usr_'.$useno,'r');
	$numGroup=fread($fh,12);
	if ($numGroup>0){
		echo '<br>My Groups<table width=100% align=center>';
		include '../CheckGroupStat.php';
		for ($counter=1; $counter<=$numGroup; $counter+=1){
			$lg=trim(fread($fh,12));
			$fh2=fopen('../Workspace/lg_'.$lg.'_desc','r');
			$t1=fgets($fh2);
			$t2=fgets($fh2);
			$t2=fgets($fh2);
			fclose($fh2);
			echo '<td><a href=Group.php?lg='.trim($lg).' title ="'.$t2.'">'
			 .$t1.'</a>('.$RTtl[GroupStat($lg,$useno)].')';
			if (($counter%3)==0){
				echo '<tr>';
			}
		}			//40
	}
	fclose ($fh);

}
else{
	include 'logon.htm';
}

?>