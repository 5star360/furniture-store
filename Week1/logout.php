<?php
session_start();
session_destroy();
header('Location: /furniture-store/login.php');
exit;
