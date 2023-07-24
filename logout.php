<?php
//Include dbconnect.php for siteurl
include "partials/dbconnect.php";

//1. Destroy The Session
session_unset();
session_destroy();

//2. Redirect to Login Page
header("location:".$siteurl."admin/login.php");

?>