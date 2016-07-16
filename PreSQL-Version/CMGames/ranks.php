<?php
session_start();
include '../CheckGroupStat.php';
include '../givetake.php';
$t1=$_SESSION['useno'];
$lg=htmlspecialchars($_GET['lg']);
if (file_exists('../Workspace/lg_'.$lg.'_desc')){
	$rnk=GroupStat($lg,$t1);
	$fh=fopen('../Workspace/lg_'.$lg.'_desc','r');
	$t1=fgets($fh);
	echo '<Title>'.$t1.' - Adjust Ranks</Title>';
	fclose($fh);
	echo $t1.' Group - Rank Adjustment<br>'.
			'<a href=Group.php?lg='.$lg.'>Return to Group Page</a>&#160; &#160; &#160; <a href=home.php>Home</a><br>';
	if ($rnk<'H'){
		echo "<form action='ranks.php?lg=".$lg."' method='post'><select name='Membernumber'>";
		$fh=fopen("../Workspace/lg_".$lg."_usr",'r+');
		$numpar=fread($fh,12);
		if (isset($_POST['NewRank'])){
			for ($counter=1; $counter<=$numpar;$counter+=1){ 
				$tvar=fread($fh,8); 
				if (trim($tvar)==trim($_POST['Membernumber'])){
					if (($_POST['NewRank']=='M') or ($_POST['NewRank']=='J')){
						$fw=fwrite($fh,$_POST['NewRank'],1);
					}
					elseif ($rnk=='C'){
						$fw=fwrite($fh,$_POST['NewRank'],1);
					}
					$counter=$numpar;
				}
				$tvar2=trim(fread($fh,4));
			}
		
		rewind ($fh);
		unset($_POST['NewRank']);
		$numpar=fread($fh,12);
		}
		for ($counter=1; $counter<=$numpar;$counter+=1){ 
			$tvar=fread($fh,8); 
			$tvar2=trim(fread($fh,4));
			if ((($rnk<'H') and ($tvar2<'Q') and ($tvar2 >'I')) or (($rnk=='C') and ($tvar2!='C'))){
				$fh2=fopen('../Workspace/usr_'.trim($tvar).'_id','r');
				$parunam=fgets($fh2);
				$parnnam=fgets($fh2);
				fclose($fh2);  //20
				echo '<option value="'.trim($tvar).'">';
				echo $parnnam.'('.$parunam.') - '.$RTtl[$tvar2];  
			}
		}
		echo '</select><select name="NewRank">';
		if ($rnk=='C'){
			$t1='S';
			echo '<option value="'.$t1.'">'.$RTtl[$t1];
			$t1='G';
			echo '<option value="'.$t1.'">'.$RTtl[$t1];
		}
		$t1='J';
		echo '<option value="'.$t1.'">'.$RTtl[$t1];
		$t1='M';
		echo '<option value="'.$t1.'">'.$RTtl[$t1];
		fclose ($fh);
		echo '</Select>';
		echo "<input type='submit' value='Set Rank'>";
		echo '</form>';
	}
}
?>