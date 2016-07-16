<?php
session_start();
$useno=$_SESSION['useno'];
echo '<Title>My Groups</Title>';
if (isset($useno)){
	echo 'My Groups(<a href=createGroup.php>Create New Group</a>):<br><br>'.
	 '<table width=100%>'.
	 '<td>Group Name/Page<td>Your Rank<td>Official Game(Category)<td><center>Group Games</center><tr>';
	$fh=fopen('../Workspace/lg/usr_'.$useno,'r');
	$numGroup=fread($fh,12);
	if ($numGroup>0){
		include '../CheckGroupStat.php';
		for ($counter=1; $counter<=$numGroup; $counter+=1){
			$lg=trim(fread($fh,12));
			$fh2=fopen('../Workspace/lg_'.$lg.'_desc','r');
			$t1=fgets($fh2);
			$t3=fgets($fh2);
			$t2=fgets($fh2); //20
			fclose($fh2);
			$rnk=GroupStat($lg,$useno);
			echo '<td><a href=Group.php?lg='.trim($lg).'>'
			 .$t1.'</a><td>'.$RTtl[$rnk].'<td>'
			 .$t2.'('.$t3.')<td>';
			if ($rnk<'N'){
				echo '<center><a href=createevent.php?lg='.$lg.'>Create Closed Event</a>'
				 .' <a href=closedgames.php?lg='.$lg.'>(list of Closed Events)</a> &#160; |';
				if ($rnk<'K'){
					echo ' <a href="createevent.php?lg='.$lg.'&lgt=1">Create Official Event</a>';
				}
				echo ' <a href=officialgames.php?lg='.$lg.'>(list of Official Events)</a></center>';
			}
			echo '<tr>';
		}			
	}
	fclose ($fh);

	echo '</table>';
}
?>