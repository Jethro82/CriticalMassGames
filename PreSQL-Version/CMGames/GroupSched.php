<?php
session_start();
if (!isset($_SESSION['useno'])){
	echo 'You are not logged in';
}
else{
	$lg=htmlspecialchars($_REQUEST['lg']);
	if (!file_exists('../Workspace/lg_'.$lg.'_desc')){
		echo "Group does not exist";
	}
	else{
		include '../CheckGroupStat.php';
		$rnk=GroupStat($lg,$_SESSION['useno']);
		if ($rnk<'M'){
			$fh=fopen('../Workspace/lg_'.$lg.'_usr','r');
			$nument=fread($fh,12);
			include '../schedarr.php';
			$sc2=array( 0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF);
			for ($count=0; $count<$nument; $count+=1){
				$unt=fread($fh,8);
				$urt=fread($fh,4);
				if ($urt<'N'){
					$fh2=fopen('../Workspace/sc/usr_'.trim($unt),'r');
					$grd=str2arr(fread($fh2,42));
					$tv=fclose($fh2);
					for ($cnt2=0; $cnt2<7; $cnt2+=1){
						$sc2[$cnt2]=$sc2[$cnt2]&$grd[$cnt2];
					}
				}
			}
			$tv=fclose($fh);
			echo 'times that ALL group members are GENERALLY available:';
			include '../sched.php';
			echo '<br><a href=Group.php?lg='.$lg.'>Return to Group</a>';
				
		}else{
		}
	}
}
?>