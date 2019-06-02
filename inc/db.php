<?php 
/////////////////////////////////////////////////////////////////
// Database connection page                                  ///
// This connection string is intended for MSQL DB           ///
// Check the connection string format for other DB engine  ///
/////////////////////////////////////////////////////////////
$servername	= "localhost";
$username	= "root";
$password	= "mr_smooth25";
$dbname		= "patientintegtest";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");



?>