<?php
session_start();
include_once "connect.php";
   unset($_SESSION['UserID']);
    $_SESSION['mand'] = [];
print('<script type="text/javascript">location.href = "login.php";</script>'); /*SRC="https://stackoverflow.com/questions/4871942/how-to-redirect-to-another-page-using-php"*/
?>