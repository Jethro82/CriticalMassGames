<form action='/newGroup.php' method='post'>
Group Name:<input type='text' name='Lname'><br>
Official Game:<br>
Game:<input type='text' name='OGame'>
Category:<select name='OCat'>
<?php
include '../SelCat.htm';
?>
</select>
Description(note HTML tags allowed, but all ';' will be replaced by ','):
<br><textarea name='Description' row='7' columns='50'></textarea><br>
Will this group require approval to join?
<select name='opcl'>
<option value='OPEN'>No - this is an open group</option>
<option value='Closed'>Yes, this is a closed group</option>
</select>
<br>Region:<select name='regcode'>

<?php
?>
<option value='CanMB'>Manitoba (Canada)</option></select>
Should this Group be visible in a search<select name="searchable"><option value="yMJJ">Yes<option value="nCCC">no</select><br>
<input type='submit' value='Create Group!'></form>