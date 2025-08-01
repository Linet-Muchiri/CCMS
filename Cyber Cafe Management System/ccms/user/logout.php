<?php
session_start();
session_unset();
session_destroy();

// Redirect to landing page (index.php)
header("Location: ../index.php");
exit();
