<?php
session_start();
session_destroy();

header ('location:?controller=pages&action=home');
//echo 'log out successful';

?>
