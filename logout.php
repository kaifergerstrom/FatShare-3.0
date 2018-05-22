<?php
include('./scripts/initialize.php');
session_start();
session_destroy();
DB::header("index.php");
?>