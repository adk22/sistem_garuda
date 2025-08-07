<?php
session_start();
session_destroy();
header("Location: ../umum/loginadmin.php?logout=success");
exit;
?>
