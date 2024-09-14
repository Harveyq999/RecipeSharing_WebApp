<?php
require_once ('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');

session_start();
session_unset();
session_destroy();

header('location: signin.php');
?>