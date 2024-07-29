// logout.php
<?php
session_start();
session_destroy();
header("Location: ../Sign_in.html");
exit();
?>
