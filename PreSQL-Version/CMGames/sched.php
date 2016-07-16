<?php
session_start();
if (isset($_SESSION['useno'])){
	$fh=fopen('../Workspace/sc/usr_'.$_SESSION['useno'],'r+');
	$sched=fread($fh,42);
	include '../schedarr.php';
	$sc2=str2arr($sched);
	$hflag=htmlspecialchars($_REQUEST['hflag']);
	if (isset($_POST['action']) or ($hflag>0)){
		$h1=$_POST['h1'];
		$h2=$_POST['h2'];
		if ($h2<$h1){
			$h2=$h1;
		}
		$flag=(2<<$h2)-(1<<$h1);
		$act=$_POST['action'];
		$day=$_POST['wday'];
		if ($hflag>0){
			$day=htmlspecialchars($_REQUEST['Dy']);
			$sc2[$day]=$sc2[$day] ^ $hflag; //20

		}
		if ($act=='add'){
			$sc2[$day]=$sc2[$day] | $flag;
		}
		elseif ($act=='sub'){
			$flag=((2<<24)-1)-$flag;  //20
			$sc2[$day]=$sc2[$day]&$flag;
		}		elseif ($act=='total'){
			$sc2=str2arr('FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');
		}elseif($act=='clear'){
			$sc2=array(0,0,0,0,0,0,0);
		}
		unset ($_POST['action']);
		$t1=rewind($fh);
		$t1=fwrite($fh,ar2str($sc2),42);
	}
	$tv1=fclose ($fh);
	$lnk='sched.php?';
	include '../sched.php';
	echo '<table align=center><td><form action="/sched.php" method="post">'.
	 '<input type="hidden" name="action" value="clear"><input type="submit" value="Clear Availability"></form>'.
	 '<td><form action="/sched.php" method="post"><input type="hidden" name="action" value="total"><input type="submit" value="Always Available"></form></table>'.
	 '<form action="/sched.php" method="post"><center>On:<select name="wday"><option value="0">Sunday'.  //40
	 '<option value="1">Monday'.	 '<option value="2">Tuesday'.	 '<option value="3">Wednesday'.	 '<option value="4">Thursday'.
	 '<option value="5">Friday'.
	 '<option value="6">Saturday</select>'.
	'from<select name="h1">';
	for ($count=0; $count<24; $count+=1){
		echo '<option value="'.$count.'">'.$count.':00-'.$count.':59';
	}
	echo '</select>to<select name="h2">';
	for ($count=0; $count<24; $count+=1){
		echo '<option value="'.$count.'">'.$count.':00-'.$count.':59';
	}
	echo '</select>is '.
		'<select name="action"><option value="add">open<option value="sub">not available</select><input type="submit" value="Make Changes!"></form>';}
?>