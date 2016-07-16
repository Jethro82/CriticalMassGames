<?php
include 'setGsearch.php';
include '../checkformat.php';
$cat=substr($_POST['Category'],-1);
$catname=substr($_POST['Category'],0,-1);
$ssgam=trim($_POST['GameString']);
$ssev=trim($_POST['GroupString']);
$regcode=$_POST['regcode'];
echo 'Displaying all matching groups in '.$catname.' (in Region:'.$regcode.')<br>';
echo '<table><td>Group Name<td>Game<tr>';
$fh=fopen('../Workspace/srch_tbls/LG_CAT_'.$cat,'r+');
$numlg=fread($fh,12);
$hit='no';
for ($counter=1; $counter<=$numlg; $counter+=1){
	$rg=fread($fh,5);
	$gm=fread($fh,70);
	$grna=fread($fh,70);
	$grno=trim(fread($fh,8)); //40
	$thit='yes';
	if ($ssgam!=''){
		if ((strpos('!'.$gm,$ssgam)==false)){
			$thit='';
		}
	}
	if ($ssev!=''){
		if (strpos('!'.$grna,$ssev)==false){
			$thit='';
		}
	}
	if ($regcode!=$rg){ //60
		$thit='';
	}
	if ($thit=='yes'){ 
		echo '<td><a href="Group.php?lg='.$grno.'">'.$grna.'</a><td>'.$gm.'<td><tr>';
		$hit='';
	}
}
if ($hit=='no'){
	echo '<td>{No Such Groups found}';
}
?>
</table>