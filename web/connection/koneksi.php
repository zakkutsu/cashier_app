<?php
	$host = "localhost";
	$user = "root";
	$pass = "mysql";
	
	$db = "db_restoran";
	$conn = mysqli_connect($host,$user,$pass,$db);
	
	if (!$conn) {
   		die('Maaf koneksi gagal: '. mysqli_connect_error());
	}
	else{
		// Koneksi berhasil
		mysqli_select_db($conn, $db);
	}	
?>