<?php
session_start();
echo substr($_SESSION[NM], 0,strpos($_SESSION[NM], ' '))."_".rand(1000, 9999);
?>