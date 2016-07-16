<?php
Session_Start();
if (isset($_SESSION['username'])){
	$lg=htmlspecialchars($_REQUEST['lg']);
	if (($lg>0) and (file_exists('../Workspace/lg_'.$lg.'_desc'))){
		include '../CheckGroupStat.php';
		$lgt=0;
		$rnk=GroupStat($lg,$_SESSION['useno']);
		if ($rnk<'N'){
			$lgt=1;
		}
		if (($rnk<'K') and (htmlspecialchars($_REQUEST['lgt'])==1)){
			$lgt=2;
		}
		
	}
	if (isset($_POST['Ename'])){
		$err='';
		if ($_POST['Ename']==''){
			$err="Please give this event a name<br>";
		}  //20
		if ($_POST['Game']==''){
			$err.="Please specify the Game<br>";
		}
		include '../checkformat.php';
		$t1=checkformat($_POST['date'],'##/##/####');
		if ($t1!='correct'){
			$err.='date '.$t1.'<br>';
		}
		$tvar2=$_POST['date'];
		$tvar2=substr($tvar2,-2).substr($tvar2,2,4).substr($tvar2,0,2);
		if ($tvar2<date('y/m/d')){
			$err.= "this date is in the past<br>";  //20
		}
		if ($_POST['droptime']=='other'){
			$tme=$_POST['time'];
		}
		else {
			$tme=$_POST['droptime'];
		}
		$t1=checkformat($tme,'##:##'); //40
		if ($t1!='correct'){
			$err.='time '.$t1.'<br>';
		}  
		if ($_POST['Min']>$_POST['Max']){
			$err.="Minimum must be greater then maximum<br>";
		}
		if ($_POST['Min']<2){
			$err.="It is nonsensical to have an event with a minimum of less than two person<br>";
		}
		if ($err==''){
			$t1=$_POST['Description'];
			$t1=str_replace("\n",'<br>',$t1);
			$t1=str_replace(';', ',', $t1);
			$fh=fopen('../Workspace/evnno','r+');
			$t3=fread($fh,12);
			$t3+=1;
			rewind($fh);
			$t2=fwrite($fh,trim($t3));
			fclose($fh);
			$fh=fopen('../Workspace/evn_'.$t3."_desc",'w'); //60
			$t2=fwrite($fh,$_POST['Ename'].
"\n".substr($_POST['Category'],0,-1).
"\n".$_POST['Game'].
"\n".$t1.
"\n".$_POST['date'].
"\n".$tme);
			if ($_POST['etime']!=''){
				$t2=fwrite($fh," until ".$_POST['etime']);
			}   //40
			$t2=fwrite($fh,"\n".$_POST['Open'].
"\n".$_POST['Min'].
"\n".$_POST['Max'].
"\n");
			fclose ($fh);
			$fh=fopen('../Workspace/frob1.csv','a');
			$t2=fwrite($fh,$t3.','.$_POST['Category'].','.$_POST['Game'].','.$_POST['Min'].','.$_POST['Max']."\n");
			fclose ($fh);
			$fh=fopen('../Workspace/evn_'.$t3.'_prt','w+');
			include "../givetake.php";
			$t1=listadd($fh,$_SESSION['useno']); //80
			$fh=fopen('../Workspace/el/usr_'.$_SESSION['useno'],'r+');
			$t1=listadd($fh,$t3);			
			if ($lgt>0){
				include '../LNotice.php';
			}
			if ($lg>0){
				$fh=fopen('../Workspace/srch_tbls/LG_'.$lg,'r');
				$tv1=fread($fh,5);
				$nrank=substr($tv1,$lgt,1);
				if (($_POST['Open']==$lg) and ($lgt==2)){
					$nrank=substr($tv1,3,1);
				}
				$tv1=substr($tv1,4,1);
				fclose($fh);
			}
			if ($lgt!=2){
				$tv1=substr($_POST['Category'],-1);
			}
			if (($_POST['searchable']=='yes') and (($lgt==0) or ((($lgt==1) or ($lgt==2)) and ($rnk<=$nrank)))) {
				$fh=fopen('../Workspace/srch_tbls/EVN_CAT_.'.$tv1,'r+');
				$sz=fread($fh,12);
				$tv=fseek($fh,(168*$sz+12));
				$tv=fwrite($fh,$_POST['date'].$tme.$_POST['regcode'].s70($_POST['Game']).s70($_POST['Ename']).Int8($t3),168);
				$sz+=1; //100
				$sz="    "+int8($sz);
				$tv=rewind($fh);
				$tvar=fwrite($fh,$sz,12);
				fclose($fh);
			}
			unset ($_POST['Ename']);
			echo '<meta http-equiv="REFRESH" content="0;url=event.php?evno='.$t3.'">';
				}
		else{
			echo $err;
		}
	}
	include '../Create.php';
}
else{
	echo 'You are not logged in';	
	include 'logon.htm';
}

?>
