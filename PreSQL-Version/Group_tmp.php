<?php
$lg=htmlspecialchars($_GET['lg']);
if (file_exists('../Workspace/lg_'.$lg.'_desc')){
	$fh=fopen('../Workspace/lg_'.$lg.'_desc','r');
	$lgn=fgets($fh);
	echo '<Title>'.$lgn.'</Title>'.
	 $lgn.'<br>';
	if (!isset($_SESSION['useno'])){
		echo "You are not logged in - ";
		$rank='Q';
	}
	else{
		$rank=GroupStat($lg,$_SESSION['useno']);
	}
	$t1=fgets($fh);
	$t2=fgets($fh);
	if ($rank!='Q'){
		echo 'Your status in this Group is: '.$RTtl[$rank];
	}
	else
	{
		echo 'You are not a member of this Group';
	}
	echo '<br>Official Group Game:'.$t2. '(Category:'.$t1.') - ';
	$opcl=fgets($fh);
	$t1=fgets($fh); //20
	fclose ($fh);
	echo "<small>**this is a ".$opcl.' Group**</small><br>';
	echo '<a href=home.php>Home</a>&#160; &#160; &#160; ';
	if (($rank=='Q') and isset($_SESSION['useno'])){
		echo '<a href=jGroup.php?lg='.$lg.'>Join Group</a>&#160; &#160; &#160; ';
	}
	if ($rank<'Q' and $rank>'C'){
		echo '<a href=lGroup.php?lg='.$lg.'>Leave Group</a>&#160; &#160; &#160; ';
	}
	if ($rank<'N'){
		echo '<a href=closedgames.php?lg='.$lg.'>Closed Games </a>&#160; &#160; &#160; '.
		'<a href=officialgames.php?lg='.$lg.'>Official Games</a>&#160; &#160; &#160; ';
	}
	if ($rank<'M'){
		echo '<a href=GroupSched.php?lg='.$lg.'>General Availabilty</a>&#160; &#160; &#160; ';
	}
	if ($rank<'H'){
		echo '<a href=ranks.php?lg='.$lg.'>Adjust Group Ranks</a>&#160; &#160; &#160; ';
	}
	if ($rank=='C'){
		echo '<a href=GroupPerm.php?lg='.$lg.'>Adjust Searchabilty of Group Events</a>&#160; &#160; &#160; ';
	}
	echo '<a href="mailto:?subject='.$t2." Group - CMGames: ".$lgn."&body=http://cmgames.fransen.ca/Group.php?lg=".$lg.'">Send link to a friend</a>&#160; &#160; &#160; '.
	"<a href=ander/groups-faq.htm>Help about Groups</a>";
	echo '<br>Description:'.$t1;			
	$efile='../Workspace/lg_'.$lg.'_usr';
	$fh=fopen($efile,'r');
	echo '<br>Members:<table align=center width=80% border=1>';
	$numpar=fread($fh,12);
	for ($counter=1; $counter<=$numpar;$counter+=1){ 
		$tvar=fread($fh,8); //40
		$tvar2=trim(fread($fh,4));
		if ($tvar2<='M'){
			$fh2=fopen('../Workspace/usr_'.trim($tvar).'_id','r');
			$parunam=fgets($fh2);
			$parnnam=fgets($fh2);
			fclose($fh2);
			echo '<td>'.$parnnam.'('.$parunam.')';
			if ($tvar2<'M'){
				echo '- '.$RTtl[$tvar2];
			}
		}
		if (($counter%4)==0){    
			echo '<tr>'; //60
		}
	}
	echo '</table>';
}
else {
		echo 'Group does not Exist<br>'.
		'<a href=home.php>Home</a>';
}
?>