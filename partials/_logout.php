<?php
session_start();

echo "logging you out now...please wait";


session_destroy();
header("Location: /forum project");
?>