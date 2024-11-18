<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
setcookie('smedia_popup_remember', false);
session_unset();

// destroy the session
session_destroy();

header("Location: login.php");
?>

</body>
</html>
