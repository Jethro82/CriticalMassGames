<?php
$_SESSION['Lgame']=0;
$evno=htmlspecialchars($_REQUEST['evno']);
$efile="../Workspace/evn_".$evno."_desc";
if (file_exists($efile)){
	$fh=fopen($efile,'r') or die("can't open file");
	$evnam=fgets($fh);
	echo "<Title>".$evnam."</Title>";
	echo $evnam."<br>";
	$tvar=fgets($fh);
	echo $tvar."-";
	$game=fgets($fh);
	echo $game."<br>";
	$tvar=fgets($fh);
	$dat=fgets($fh);
	$tim=fgets($fh);
	$lg=trim(fgets($fh));
	 echo "<br>From ".$tim.", ".$dat."<br>";
	if ($lg==0){
		echo "This is an open event"; //20
	}   
	else {
		$fh2=fopen('../Workspace/lg_'.trim($lg).'_desc','r');
		$t1=fgets($fh2);
		fclose($fh2);
		echo "only open to members of the <a href=Group.php?lg=".$lg.">".$t1." Group</a><br>";
	}
	echo "<br> Description:".$tvar."<br>";
	$minp=fgets($fh);
	$maxp=fgets($fh);
	echo "Minimum: ".$minp."&#160; &#160; Maximum: ".$maxp;
	fclose ($fh);
	$efile="../Workspace/evn_".$evno."_prt";
	$fh=fopen($efile,'r') or die("can't open file");
	echo "<br>Participants:<table align=center width=80% border=1>";
	$numpar=fread($fh,12);
	for ($counter=1; $counter<=$numpar;$counter+=1){
		$tvar=fread($fh,12);
		$fh2=fopen("../Workspace/usr_".trim($tvar)."_id",'r');
		$parunam=fgets($fh2);
		$parnnam=fgets($fh2);
		fclose($fh2);
		echo '<td>'.$parnnam."(".$parunam.")";
		if (($counter%4)==0){    //40
			echo "<tr>";
		}
	}
	echo "</table>";

}
else {
	echo "Event does not exist<br>";
}
?>
 <a href=home.php>Home</a>
&#160; &#160; &#160; 
<?php
if (file_exists($efile)){
	$qd=EvUseCheck($evno);
	if (($qd=="Join ") or ($qd=="Leave")){
		echo "<a href=".trim($qd)."ev.php?evno=".$evno.">".$qd." this event</a>";
	}
	else{
		echo $qd;
	}
	echo '&#160; &#160; &#160; <a href="mailto:?subject=Game of '.$game.' at CMGames: '.$evnam.'&body=http://cmgames.fransen.ca/event.pho?evno='.$evno.'">Email to a friend</a>';
}
?>