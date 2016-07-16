<?php
session_start();
$usenum=$_SESSION['useno'];
include '../CheckGroupStat.php';
$lg=htmlspecialchars($_GET['lg']);
$rnk=GroupStat($lg,$usenum);
if ($rnk=='C'){
	$fh=fopen('../Workspace/srch_tbls/LG_'.$lg,'r+');
	$t1=fread($fh,1);
	if (isset($_POST['cgame'])){
		$t=fwrite($fh,$_POST['cgame'].$_POST['ogame'].$_POST['cogame'],3);
		$t=rewind($fh);
		$t1=fread($fh,1);
		unset ($_POST['cgame']);
	}
	$perm=fread($fh,3);
	fclose ($fh);
	echo '<form action="/GroupPerm.php?lg='.$lg.'" method="post">';
	echo '<a href=home.php>Home</a> &#160; &#160; &#160; <a href=Group.php?lg='.$lg.'>Return to Group Page</a><br>'
	 .'Is this group itself searchable[unchangable]?:'.$t1.'<br>' //20
	 .'Who should have authority to make SEARCHABLE games in this group?<br>';
	echo 'Closed Games:<select name="cgame"><option value="'; 
	echo substr($perm,0,1).'">'.$RTtl[substr($perm,0,1)].'</option>'
	 .'<option value="M">'.$RTtl['M'].'</option>'
	 .'<option value="J">'.$RTtl['J'].'</option>'
	 .'<option value="G">'.$RTtl['G'].'</option>'
	 .'<option value="C">'.$RTtl['C'].'</option>'
	 .'</select><br><br>';
	echo 'Official Games:<select name="ogame"><option value="';
	echo substr($perm,1,1).'">'.$RTtl[substr($perm,1,1)].'</option>'
	 .'<option value="J">'.$RTtl['J'].'</option>'
	 .'<option value="G">'.$RTtl['G'].'</option>'
	 .'<option value="C">'.$RTtl['C'].'</option>'
	 .'</select><br><br>';
	echo 'Closed Official Games:<select name="cogame"><option value="';
	echo substr($perm,2,1).'">'.$RTtl[substr($perm,2,1)].'</option>'
	 .'<option value="J">'.$RTtl['J'].'</option>'
	 .'<option value="G">'.$RTtl['G'].'</option>'
	 .'<option value="C">'.$RTtl['C'].'</option>'
	 .'</select><br>'; //40
	echo '<input type="submit" value="Set New Permissions">'
	 .'</form>'; //40
}

?>