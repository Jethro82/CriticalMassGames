<title>CMGames - Search for Groups</title>
<form action='groupsearch.php' method='post'>
Search for <input type='text' name='GameString'
<?php
if (isset($_POST['GameString'])){
	echo 'value="'.$_POST['GameString'].'"';
}
?>
>  in game type<br>
Search for <input type='text' name='GroupString'
<?php
if (isset($_POST['GroupString'])){
	echo 'value="'.$_POST['GroupString'].'"';
}
?>
> in Group name<br>
Category <select name='Category'>
<?php
include '../SelCat.htm';
?>
</Select>
Region:<select name='regcode'>
<?php
?>
<option value='CanMB'>Manitoba (Canada)</option><br>
<input type='submit' value='Submit'></Form>
