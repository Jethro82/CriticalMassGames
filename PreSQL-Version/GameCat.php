<?php
$GameCat = array(1 => 'Field Sports', 2 => 'Board/Card Games'); 
function DropCat($nm){
	echo '<select name="'.$nm.'">';
	for ($counter=1; $counter<=2; $counter+=1){
		echo "<option value='".$counter."'>".$GameCat[$counter].'</option>';
	}
	echo '</select>';
return;}
?>