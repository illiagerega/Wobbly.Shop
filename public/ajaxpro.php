<?php

	define (DB_USER, "toor");
	define (DB_PASSWORD, "toor");
	define (DB_DATABASE, "ishop2");
	define (DB_HOST, "localhost");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


	$sql = "SELECT product.title FROM product 
			WHERE title LIKE '%".$_GET['query']."%'
			LIMIT 10"; 
	$result = $mysqli->query($sql);
	

	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['title'];
	}


	echo json_encode($json);