<?php
session_start();
$err='';
if (ISSET($_POST['NotForm'])){
	$fh=fopen('../Workspace/usepass','r+');
	$uname=substr($_POST['uname'].'............',0,12);
	if ($uname=='............'){
		$err.='Username not selected<br>';
	}
	$numuse=fread($fh,12);
	for ($counter=1; $counter<=$numuse; $counter+=1){
		$t1=fread($fh,12);
		if ($t1==$uname){
			$err.='User name already exists<br>';
			$counter=$numuse;
		}
		$t1=fread($fh,12);
	}
	if ($_POST['pwd']!=$_POST['cpwd']){
		$err.='Passwords not the same<br>';
	} //20
	if (strlen($_POST['pwd'])<6){
		$err.="Please make password at least six character<br>";
	}
	if (strlen($_POST['uname'])<6){
		$err.="Please make username at least six character<br>";
	}
	if ($_POST['email']!=$_POST['cmail']){
		$err.='Emails not the same<br>';
	}				//20
	if ($_POST['NotForm']!='email'){
		if  (strlen($_POST['CellNo'])!=10){
			$err.="Cell phone number wrong length, please include area code<br>";
		}
		else{
			for ($counter=0; $counter<10; $counter+=1){
				$t1=substr($_POST['CellNo'],$counter,1);
				if (($t1<'0') or ($t1>'9')){
					$err.='Not valid cell number';
					$counter=10;
				} //40
			}
		}
	}
	rewind($fh);
	fseek($fh,24*$numuse+12);
	if ($err==''){
		$t1=fwrite($fh,$uname,12);
		$pwd=substr($_POST['pwd'].'............',0,12);
		$t1=fwrite($fh,$pwd,12);
		$t1=rewind($fh);
		$numuse+=1;
		$t1=fwrite($fh,$numuse,12);
		fclose($fh);
		$fh=fopen('../Workspace/usr_'.trim($numuse).'_id','w'); //40
		$t1=$_POST['uname']."\n".$_POST['rname']."\n".$_POST['NotForEvents']."\n".$_POST['email']."\n";
		$t1=fwrite($fh,$t1); 
		if ($_POST['NotForm']=='email'){
			fwrite($fh,$_POST['email']."\n");
		}
		else{ //60
			fwrite($fh,$_POST['CellNo'].$_POST['NotForm']."\n");
		}
		fclose($fh);
		$fh=fopen("../Workspace/el/usr_".$numuse,'w');
		$t1=0;
		fwrite($fh,$t1);
		fclose($fh);
		$fh=fopen("../Workspace/lg/usr_".$numuse,'w');
		fwrite($fh,$t1);
		fclose($fh);
		$fh=fopen('../Workspace/sc/usr_'.$numuse,'w');
		fwrite($fh,'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',42);
		fclose($fh);
		$_SESSION['useno']=$numuse;
		$_SESSION['username']=$_POST['uname'];
		echo '<frameset rows="90%,10%"><frame src=home.php name="showframe"><frame src=ander/f2.htm name="menuframe">';
	}
	else{
	echo $err;
	include 'ander/signup.htm';
	}
}

?>
