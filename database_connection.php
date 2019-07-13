<?php 
	$connect = new PDO('mysql:host=localhost;dbname=inventory_management','root','');
	if(!isset($_SESSION)){
		session_start();
	}
	

 ?>