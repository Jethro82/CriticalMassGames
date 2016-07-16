<?php
session_start();
session_destroy();
?>
<head>
   <script language="JavaScript">
   <!--
   function breakOut() 
      { if (window != top) top.location.href = location.href; }
   -->
   </script>
</head>
<body onload="breakOut();">
<?php
echo 'You have now succesfully logged out.';
include 'logon.htm';
?>
