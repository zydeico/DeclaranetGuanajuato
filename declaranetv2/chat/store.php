<?php
session_start();
$content = $_POST['content'];
$_SESSION['content'] = $content;
echo "asd";
?>