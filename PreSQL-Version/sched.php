<table cellpadding=0 width=85% align=center>
<td><td align=center><b>Sunday<td align=center><b>Monday<td align=center><b>Tuesday<td align=center><b>Wednesday<td align=center><b>Thursday<td align=center><b>Friday<td align=center><b>Saturday<tr>
<?php
for ($cnt2=0; $cnt2<24; $cnt2+=1){
		echo '<td align=right><b>'.$cnt2.':00-'.$cnt2.':59';
	for ($counter=0; $counter <7; $counter+=1){
		if ($sc2[$counter] & (1<<$cnt2)){
			$tcol='green';
		}else{
			$tcol='grey';
		}

		echo '<td ';
		if (isset($lnk)){
			echo ' OnClick="window.location='."'".$lnk.'Dy='.$counter.'&hflag='.(1<<$cnt2)."'".'" onmouseover="this.bgColor='."'"."purple'".'" onmouseout="this.bgColor='."'".$tcol."'".'" ';
		}
		if ($cnt2==0){
			echo 'width="13.1%" ';
		}
		echo 'bgcolor="'.$tcol.'">';
	}
	echo '<tr>';
}
?>
</table>