<title>CMGames - search for Event</title>
<form action='eventsearch.php' method='post'>
<Script src=ander/datepick.js></script>
Search for <input type='text' name='GameString'
<?php
if (isset($_POST['GameString'])){
	echo 'value="'.$_POST['GameString'].'"';
}
?>
>  in game type<br>
Search for <input type='text' name='EventString'
<?php
if (isset($_POST['EventString'])){
	echo 'value="'.$_POST['EventString'].'"';
}
?>
> in Event name<br>
Starting between(for optimal results please use hh:mm with leading zeroes, on the 24 hour clock):<input type='text' name='stime'> and <input type='text' name='ltime'><br>
Category <select name='Category'>
<?php
include '../SelCat.htm';
?>
</Select>
Region:<select name='regcode'>
<?php
?>
<option value='CanMB'>Manitoba (Canada)</option></select><br>
Happening Between:<input type='text' name='sdate'><input type='button' value='Calendar' onclick="displayDatePicker('sdate', false, 'dmy', '/');"> and <input type='text' name='ldate'><input type='button' value='Calendar' onclick="displayDatePicker('ldate', false, 'dmy', '/');"><br>

<input type='submit' value='Submit'></Form>
