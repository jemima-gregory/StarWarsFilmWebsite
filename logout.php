<?php
session_start();
session_unset(); //unset session variables
session_destroy(); //destroy data
header("Location: login.php");
exit();
?>