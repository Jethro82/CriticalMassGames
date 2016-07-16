<?php
echo "<form action='createevent.php";
if ($lgt>0){
	echo '?lg='.$lg;
}
if ($lgt==2){
	echo '&lgt=1';
}
echo "' method='post'>";
?>
Name of your Event:<input type='text' name='Ename' maxlength=50>
<?php
if ($lgt==2){
	$fh=fopen('../Workspace/lg_'.$lg.'_desc','r');
	$t1=fgets($fh);
	$t1=fgets($fh);
	$t2=fgets($fh);
	fclose($fh);
	echo "Category: <input readonly='true' type='text'  STYLE='color: #FF0000;'' name='Category' value='".$t1."'>Game: <input readonly='true' type='text'  STYLE='color: #FF0000;' name='Game' 	value=".'"'.$t2.'">';
} //20
else{
	echo "Category: <select name='Category'>";
	include "../SelCat.htm";
	echo "</select>Game:<input type='text' name='Game'>";
}
?>
<br>

Description(note HTML tags allowed, but all ';' will be replaced by ',' for security reasons):
<br><textarea name='Description' row='7' columns='50'></textarea><br>
<select name='Open'>
<?php
if ($lgt==1){
echo "<option value='".$lg."'>Closed Game</option>";
}
?>
<option value='0'>Open Game</option>
<?php
if ($lgt==2){
echo "<option value='".$lg."'>Closed Game</option>"; //40
}
?>

</select>
Critical Mass(no of Participants):<input type='text' name='Min'>
Maximum Number of Participants:<input type='text' name='Max'>
<br>
<script src='ander/focact.js'></script>
Start Time: <select name='droptime' onchange="OptText(droptime,time,'other')">
<option value='20:00'>8p (20:00)</option>
<option value='21:00'>9p (21:00)</option>
<option value='other'>Other(Specify)</option>
</select>
or (hh:mm - 24 hour - include leading 0 for hours before 10am): <input disabled=true type='text' name='time' maxlength=5>
until:  <input type='text' name='etime'><br>
<?php
if ($lg>0){
	$fh=fopen('../Workspace/srch_tbls/LG_'.$lg,'r');
	$tv=fread($fh,$lgt);
	$nrank=fread($fh,1);
	fclose($fh);
}
if ( ($lgt==0) or ((($lgt==1) or ($lgt==2)) and ($rnk<=$nrank))) {
	echo 'Should this game be visible in a search<select name="searchable"><option value="yes">Yes<option value="no">no</select>';//60
}
?>
<br>Region:<select name='regcode'>

<?php
?>
<option value='CanMB'>Manitoba (Canada)</option><br>
Day(dd/mm/yyyy): <input type='text' name='date' maxlength=10><Script src=ander/datepick.js></Script>
<input type='button' value='Calendar' onclick="displayDatePicker('date', false, 'dmy', '/');"><br>
<input type='submit' value='Submit'></Form>