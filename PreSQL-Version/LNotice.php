<?php
$lg=trim(htmlspecialchars($_REQUEST['lg']));
if ($lg>0){
	if (file_exists('../Workspace/lg_'.$lg.'_desc')){
		if ($_POST['Open']>0){
			$fh=fopen('../Workspace/el/lg_cl_'.$lg,'r+');
			$t1=listadd($fh,$t3);
		}
		if ($lgt==2){
			$fh=fopen('../Workspace/el/lg_of_'.$lg,'r+');
			$t1=listadd($fh,$t3);
			$fh=fopen('../Workspace/lg_'.$lg.'_usr','r');
			$nummem=fread($fh,12);
			for ($counter=1; $counter<=$nummem; $counter+=1){
				$t1=fread($fh,8);
				$t2=fread($fh,4);
				if ($t2<'N'){
					$fh2=fopen('../Workspace/usr_'.trim($t1).'_id','r');
					$t4=fgets($fh2);
					$t4=fgets($fh2); //20
					$t4=fgets($fh2);
					$t4=fgets($fh2);
					$bcc.=trim(fgets($fh2)).", ";
					fclose ($fh2);
				}
			}
			fclose ($fh);
			$fh=fopen('../Workspace/lg_'.$lg.'_desc','r');
			$t1=trim(fgets($fh));
			fclose ($fh);	
			$to      = "";
			$subject=$t1.' Group Game Notice';
			$message = 'Event has been created by the '.$t1. " Group -".$_POST['Ename'];
			$headers = "From: blackhole@criticalmass.ca\r\nBcc: ".substr($bcc,0,-1)."\r\n X-Mailer:PHP/5";
			echo '<Script>';
			$fh=fopen('../../MadameGay.txt','a');
			$t1=fwrite($fh,$subject."\n".$headers."\n".$message."\n".date('H:i, d/m/Y').' - '.$_SERVER['REMOTE_ADDR'].' - '.$_SESSION['useno']."\n");
			fclose ($fh2);
			mail($to, $subject, $message, $headers);
			echo '</Script>';
		}
	}
}
?>