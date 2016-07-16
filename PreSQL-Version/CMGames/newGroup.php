<?php
session_start();
if (isset($_SESSION['username'])){
	$err='';
	if (isset($_POST['Lname'])){
		if ($_POST['Lname']==''){
			$err='Please give this Group a name<br>';
		}
		if ($_POST['OGame']==''){
			$err.='Please set the official Group game<br>';
		}
		if ($err==''){
			$t1=0;
			$fh=fopen('../Workspace/lgno','r+');
			$lg=fgets($fh)+1;
			rewind ($fh);
			$t2=fwrite($fh,$lg);
			fclose($fh);
			$fh=fopen('../Workspace/lg_'.$lg.'_desc','w');
			$t3=$_POST['Description'];
			$t3=str_replace("\n",'<br>',$t3); //20
			$t3=str_replace(';', ',', $t3);
			$t2=fwrite($fh,$_POST['Lname']."\n".substr($_POST['OCat'],0,-1)."\n"
			 .$_POST['OGame']."\n".$_POST['opcl']."\n".$t3);
			fclose ($fh);
			$fh=fopen('../Workspace/el/lg_of_'.$lg,'w');
			$t2=fwrite($fh,$t1);
			fclose ($fh);
			$fh=fopen('../Workspace/el/lg_cl_'.$lg,'w');
			$t2=fwrite($fh,$t1);
			fclose ($fh);
			include '../givetake.php';
			$fh=fopen('../Workspace/lg_'.$lg.'_usr','w+');
			$t2=listadd($fh,Int8($_SESSION['useno']).'C');
			$fh=fopen('../Workspace/lg/usr_'.$_SESSION['useno'],'r+');
			$t2=listadd($fh,$lg);
			if ($_POST['searchable']=='yMJJ'){
				$fh=fopen('../Workspace/srch_tbls/LG_CAT_'.substr($_POST['OCat'],-1),'r+');
				$sz=fread($fh,12);
				$tv=fseek($fh,(153*$sz+12));
				$tv=fwrite($fh,$_POST['regcode'].s70($_POST['OGame']).s70($_POST['Lname']).Int8($lg),153);
				$sz+=1;
				$sz="    "+int8($sz);
				$tv=rewind($fh);
				$tvar=fwrite($fh,$sz,12);
				fclose($fh);
			}
			$fh=fopen('../Workspace/srch_tbls/LG_'.$lg,'w');
			$tv=fwrite($fh,$_POST['searchable'].substr($_POST['OCat'],-1),5);
			fclose($fh);
			unset ($_POST['Lname']);
			echo '<meta http-equiv="REFRESH" content="0;url=Group.php?lg='.$lg.'">';
		}
		else{
			echo $err; //40
			include 'createGroup.php';
		}
		
	}
}
else{
	echo 'You are not logged on';
	include 'logon.htm';
}
?>