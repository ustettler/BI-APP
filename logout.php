<?php
session_start();
// Beende die Session
session_unset();
session_destroy();
// Weiterleitung zur Login-Seite
header("Location: index.php");
exit;
?>