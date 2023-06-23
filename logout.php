<?php
include('config.php');
Session_start();
Session_destroy();
header("Location: blog.php");

?>
