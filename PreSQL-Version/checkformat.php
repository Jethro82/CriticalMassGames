<?php
function checkformat($t1,$t2){
	if (strlen($t1)!=strlen($t2)){
		return 'Incorrect Length';
	}
	for ($counter=0; $counter<strlen($t1); $counter+=1){
		$t3=substr($t1,$counter,1);
		$t4=substr($t2,$counter,1);
		if (($t3>='0') and ($t3<='9')){
			$t3='#';
		}
		if (($t3>='A') and ($t3<='Z')){
			$t3='A';
		}
		if (($t3>='a') and ($t3<='z')){
			$t3='a';
		}
		if ($t3!=$t4){
			return "Incorrect Format";
		}
	}
	return 'correct';
}
?>