<?php 
	include("database_connection.php");

	if(!isset($_SESSION['type'])){
		header("location:login.php");
	}

  include "partial/header.php";

  include "partial/footer.php";
 ?>
