<?php
	var_dump(get_loaded_extensions());

	$host = $_ENV["DB_HOST"];
	$user = $_ENV["MYSQL_USER"];
	$pass = $_ENV["MYSQL_PASSWORD"];
	$db = $_ENV["MYSQL_DATABASE"];

	$conn = new mysqli($host, $user, $pass, $db);

	// Check DB connection
	$query = "SELECT * FROM actors LIMIT 100";
	$result = $conn->query($query);

	while($row = $result->fetch_assoc()) {
		var_dump($row); 
		echo "<br>";
	}
?>